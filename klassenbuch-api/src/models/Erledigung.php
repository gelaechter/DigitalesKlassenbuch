<?php
    class Erledigung {
        
        /**
         * gruppenbezogene Ausgabe aller Erledigungen zu einer Eigenschaft
         * 
         */
        public static function read_by_gruppe($gruppe_id, $eigenschaft_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT s.*, b.beginn, b.ende, b.id AS belegung_id, IF(b.beginn<= :heute AND b.ende >= :heute, 1, 0) AS belegung_jetzt
                                        FROM schueler s
                                        INNER JOIN belegung b ON b.schueler_id = s.id 
                                        WHERE   b.gruppe_id = :id                                                 
                                        ORDER BY s.nachname, s.vorname');
                
                $stmt->bindParam(':id', $gruppe_id);                                
                $heute = date("Y-m-d");
                $stmt->bindParam(':heute', $heute);
                
                $stmt->execute();
                $schueler = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                $result = array();
                $stmt_er = $conn->prepare(' SELECT er.*, l.kuerzel AS lehrer_kuerzel
                                            FROM erledigung er
                                            LEFT JOIN lehrer l ON l.id = er.lehrer_id
                                            WHERE
                                                er.eigenschaft_id = :eigenschaft_id
                                                AND er.schueler_id = :schueler_id
                                                AND er.geloescht = 0
                                            ORDER BY er.id DESC');
                
                //Statements für das Zulesen der Mitteilungen und Zustimmungen zu einer Erledigung
                $stmt_mt = $conn->prepare("SELECT mitteilung, created_at FROM mitteilung WHERE erledigung_id = :er_id AND geloescht = 0");
                $stmt_zs = $conn->prepare("SELECT zs.*, l.kuerzel
                                           FROM zustimmung zs
                                           LEFT JOIN lehrer l ON l.id = zs.lehrer_id
                                           WHERE zs.erledigung_id = :er_id
                                           AND zs.geloescht = 0                                       
                                           ");

                //Statement für das Zulesen des Corona-Typs, falls id=-2
                $stmt_ct = $conn->prepare("SELECT ct.id as id, ctn.name, ctn.id as corona_typen_id
                                           FROM corona_typ ct
                                           INNER JOIN corona_typen ctn ON ctn.id = ct.corona_typen_id
                                           WHERE
                                           ct.erledigung_id = :er_id
                                           AND ct.geloescht = 0
                                           AND ctn.geloescht  = 0
                                           ");

                foreach ($schueler as $row){
                    
                    $stmt_er->bindParam(':eigenschaft_id', $eigenschaft_id);
                    $stmt_er->bindParam(':schueler_id', $row['id']);

                    $stmt_er->execute();
                    $res_er = $stmt_er->fetchAll(PDO::FETCH_ASSOC);

                    //Optional hier noch zulesen der Mitteilungen zu diesen Erledigungen
                    $row['zustimmung'] = array();
                    $row['zustimmung_offen'] = 0;
                    
                    //Optional hier noch zulesen der Mitteilungen 
                    //Iteration mit foreach über Ergebnis-Array $res_er, welches dann verändert/ergänzt werden
                    //soll um die Mitteilungen.
                    //Dazu ist ein foreach mit as $key => $value notwendig
                    //Veränderung dann mit $res_er[$key]['mitteilung'] = DATA                                                            
                    foreach($res_er as $er_key=>$er_data){
                        $stmt_mt->bindParam(':er_id', $er_data['id']);
                        $stmt_mt->execute();
                        $res_mt = $stmt_mt->fetchAll(PDO::FETCH_ASSOC);

                        $res_er[$er_key]['mitteilung']=  $res_mt;

                        $stmt_zs->bindParam(':er_id', $er_data['id']);
                        $stmt_zs->execute();
                        $res_zs = $stmt_zs->fetchAll(PDO::FETCH_ASSOC);

                        $res_er[$er_key]['zustimmung']=  $res_zs;

                        
                        if($eigenschaft_id==-2){
                            $stmt_ct->bindParam(':er_id', $er_data['id']);
                            $stmt_ct->execute();
                            $res_ct = $stmt_ct->fetch(PDO::FETCH_ASSOC);
                            $res_er[$er_key]['corona_typ']=  $res_ct;
                        }
                        

                    }

                    //Prüfung der eingelesenen Erledigungen (eines Schülers) auf
                    //Erfüllung der Corona-Regeln
                    //corona_testpflicht = true | false
                    if($eigenschaft_id==-2){
                        $res_er = Corona::checkCoronaStatus($res_er);
                    }

                    $row['erledigung'] = $res_er;
                    array_push($result, $row);
                }

                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }

        /**
         * lehrerbezogene Ausgabe aller Erledigungen zu einer Eigenschaft bezüglich einer Gruppe
         * Gruppe == null <=> Nur Erledigungen OHNE Zuordnung zu einer Gruppe
         */
        public static function read_by_lehrer($gruppe_id, $eigenschaft_id) {
            
            if($gruppe_id =="null"){
                $gruppe_id = null;
            }

            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT l.*, 1 AS belegung_jetzt
                                        FROM lehrer l                                        
                                        ORDER BY l.kuerzel');
                
                
                $stmt->execute();
                $lehrer = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                $result = array();
                if($gruppe_id == null){
                    $stmt_er = $conn->prepare(' SELECT er.*, :lehrer_kuerzel AS lehrer_kuerzel
                                            FROM erledigung er                                            
                                            WHERE
                                                er.lehrer_id = :lehrer_id
                                                AND er.eigenschaft_id = :eigenschaft_id                                                
                                                AND er.geloescht = 0
                                                AND er.schueler_id IS NULL
                                            ORDER BY er.id DESC');
                } else {
                    $stmt_er = $conn->prepare(' SELECT er.*, :lehrer_kuerzel AS lehrer_kuerzel,
                                                    s.id AS schueler_id, s.vorname, s.nachname, s.gruppe_id, 
                                                    b.id AS belegung_id, b.beginn, b.ende, b.gruppe_id AS belegung_gruppe_id
                                            FROM erledigung er
                                            INNER JOIN schueler s ON s.id = er.schueler_id
                                            INNER JOIN belegung b ON b.schueler_id = er.schueler_id
                                            WHERE
                                                er.lehrer_id = :lehrer_id
                                                AND er.eigenschaft_id = :eigenschaft_id                                                
                                                AND er.geloescht = 0
                                                AND b.gruppe_id = :gruppe_id
                                            ORDER BY er.id DESC');
                
                }
                
                //Statements für das Zulesen der Mitteilungen und Zustimmungen zu einer Erledigung
                $stmt_mt = $conn->prepare("SELECT mitteilung, created_at FROM mitteilung WHERE erledigung_id = :er_id AND geloescht = 0");
                $stmt_zs = $conn->prepare("SELECT zs.*, l.kuerzel
                                           FROM zustimmung zs
                                           INNER JOIN lehrer l ON l.id = zs.lehrer_id
                                           WHERE zs.erledigung_id = :er_id
                                           AND zs.geloescht = 0                                       
                                           ");


                foreach ($lehrer as $row){
                    
                    $stmt_er->bindParam(':eigenschaft_id', $eigenschaft_id);
                    $stmt_er->bindParam(':lehrer_id', $row['id']);
                    $stmt_er->bindParam(':lehrer_kuerzel', $row['kuerzel']);

                    if($gruppe_id!=null){
                        $stmt_er->bindParam(':gruppe_id', $gruppe_id);
                    }

                    $stmt_er->execute();
                    $res_er = $stmt_er->fetchAll(PDO::FETCH_ASSOC);

                    //Optional hier noch zulesen der Mitteilungen zu diesen Erledigungen
                    $row['zustimmung'] = array();
                    $row['zustimmung_offen'] = 0;
                    
                    //Optional hier noch zulesen der Mitteilungen 
                    //Iteration mit foreach über Ergebnis-Array $res_er, welches dann verändert/ergänzt werden
                    //soll um die Mitteilungen.
                    //Dazu ist ein foreach mit as $key => $value notwendig
                    //Veränderung dann mit $res_er[$key]['mitteilung'] = DATA                                                            
                    foreach($res_er as $er_key=>$er_data){
                        $stmt_mt->bindParam(':er_id', $er_data['id']);
                        $stmt_mt->execute();
                        $res_mt = $stmt_mt->fetchAll(PDO::FETCH_ASSOC);

                        $res_er[$er_key]['mitteilung']=  $res_mt;
                    }

                  
                    $row['erledigung'] = $res_er;
                    array_push($result, $row);
                }

                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }

        /**
         * Schülerbezogene Ausgabe aller Erledigungen zu einer Eigenschaft
         * 
         */
        public static function read_by_schueler($schueler_id, $eigenschaft_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                
                $stmt_er = $conn->prepare(' SELECT er.*, l.kuerzel AS lehrer_kuerzel
                FROM erledigung er
                LEFT JOIN lehrer l ON l.id = er.lehrer_id
                WHERE
                    er.eigenschaft_id = :eigenschaft_id
                    AND er.schueler_id = :schueler_id
                    AND er.geloescht = 0
                ORDER BY er.id DESC');

                $stmt_er->bindParam(':eigenschaft_id', $eigenschaft_id);
                $stmt_er->bindParam(':schueler_id', $schueler_id);

                $stmt_er->execute();
                $erledigung = $stmt_er->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                $result = array();
                
                //Zulesen der Mitteilungen und Zustimmungen zu dieser Erledigung
                $stmt_mt = $conn->prepare("SELECT mitteilung, created_at FROM mitteilung WHERE erledigung_id = :er_id");
                $stmt_zs = $conn->prepare("SELECT zs.*, l.kuerzel
                                           FROM zustimmung zs
                                           INNER JOIN lehrer l ON l.id = zs.lehrer_id
                                           WHERE zs.erledigung_id = :er_id
                                           AND zs.geloescht = 0                                       
                                           ");
                
                //Statement für das Zulesen des Corona-Typs, falls id=-2
                $stmt_ct = $conn->prepare("SELECT ct.id as id, ctn.name, ctn.id as corona_typen_id
                                           FROM corona_typ ct
                                           INNER JOIN corona_typen ctn ON ctn.id = ct.corona_typen_id
                                           WHERE
                                           ct.erledigung_id = :er_id
                                           AND ct.geloescht = 0
                                           AND ctn.geloescht  = 0
                                           ");
            

                foreach ($erledigung as $row){         
                    $stmt_mt->bindParam(':er_id', $row['id']);
                    $stmt_mt->execute();
                    $row['mitteilung'] = $stmt_mt->fetchAll(PDO::FETCH_ASSOC);
                        
                    if($row['eigenschaft_id']==-3){
                        Erledigung::update_zustimmung($row['id']);
                    }

                    if($row['eigenschaft_id']==-2){
                        $stmt_ct->bindParam(':er_id', $row['id']);
                        $stmt_ct->execute();
                        $row['corona_typ'] = $stmt_ct->fetch(PDO::FETCH_ASSOC);
                       
                    }
                    
                
                    $stmt_zs->bindParam(':er_id', $row['id']);
                    $stmt_zs->execute();
                    $row['zustimmung'] = $stmt_zs->fetchAll(PDO::FETCH_ASSOC);
                    $offen = 0;
                    $offen_gruppe = 0;
                    foreach($row['zustimmung'] as $zustimmung){
                        if($zustimmung['zustimmung']==0){
                            $offen++;
                            if($zustimmung['gruppe_id']!=null){
                                $offen_gruppe++;
                            }
                        }
                    }
                    $row['zustimmung_offen'] = $offen;
                    $row['zustimmung_gruppe_offen'] = $offen_gruppe;
                    
                    array_push($result, $row);                
                }
                
                   //Prüfung der eingelesenen Erledigungen (eines Schülers) auf
                    //Erfüllung der Corona-Regeln
                    //corona_testpflicht = true | false
                    if($eigenschaft_id==-2){
                        $result = Corona::checkCoronaStatus($result);
                    }


                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


        /**
         * 7-Tage Statistik zur Corona-Testausgabe (Eigenschaft -6)
         * 
         */
        public static function read_coronatestausgabe_wochenstatistik($startdatum) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt_t = $conn->prepare('SELECT null AS id, "Summe über alle Testausgaben" AS name, SUM(m.mitteilung) AS summe
                                        FROM erledigung er                                        
                                        INNER JOIN mitteilung m ON m.erledigung_id = er.id                                        
                                        WHERE
                                        er.eigenschaft_id = -6
                                        AND er.von >= :von
                                        AND er.von <= :bis
                                        AND m.id = (
                                                SELECT mm.id
                                                FROM mitteilung mm
                                                WHERE mm.erledigung_id = er.id
                                                ORDER BY mm.id ASC
                                                LIMIT 1
                                            )                                        
                                        AND er.geloescht = 0                                                                                
                                        ');
                
                $stmt_abit2g = $conn->prepare('SELECT null AS id, "ABIT-Anordnungen" AS name, COUNT(er.id) AS summe
                                                FROM erledigung er                                                                                        
                                                WHERE
                                                er.eigenschaft_id = 4
                                                AND er.von >= :von
                                                AND er.von <= :bis                                                
                                                AND er.geloescht = 0   

                                                UNION
                                                /*
                                                SELECT null AS id, "--> davon ABIT-Anordnungen für Schüler mit 2G-Status" AS name, COUNT(DISTINCT s.id) AS summe
                                                FROM schueler s
                                                INNER JOIN erledigung er  ON er.schueler_id = s.id                                                                                                                
                                                WHERE
                                                er.eigenschaft_id = 4
                                                AND er.von >= :von
                                                AND er.von <= :bis                                                
                                                AND er.geloescht = 0   
                                                AND s.id IN (
                                                        SELECT eer.schueler_id
                                                        FROM erledigung eer
                                                        WHERE
                                                        eer.eigenschaft_id = -2
                                                        AND eer.geloescht = 0
                                                        AND eer.von <= :von
                                                        AND eer.bis >= :bis
                                                        AND DATEDIFF(eer.bis, eer.von) > 30
                                                        AND eer.lehrer_id IS NOT NULL 
                                                        AND eer.schueler_id = s.id                                                       
                                                    )

                                                UNION
                                                */

                                                /*
                                                SELECT null as id, "Schüler mit 2G-Status (Corona-Status > 30 Tage)", count(DISTINCT s.id) as anzahl
                                                        FROM erledigung er
                                                        INNER JOIN schueler s ON s.id = er.schueler_id
                                                        INNER JOIN belegung b ON b.schueler_id = er.schueler_id
                                                        WHERE
                                                        er.eigenschaft_id = -2
                                                        AND er.geloescht = 0
                                                        AND DATEDIFF(er.bis, er.von) > 30
                                                        AND er.von <= :von
                                                        AND er.bis >= :bis
                                                        AND er.lehrer_id IS NOT NULL 
                                                        AND b.beginn <= :von
                                                        AND b.ende >= :bis   
                                                
                                                UNION

                                                SELECT null as id, "--> davon Schüler anderer Schulen mit 2G-Status (Corona-Status > 30 Tage)", count(DISTINCT s.id) as anzahl
                                                        FROM erledigung er
                                                        INNER JOIN schueler s ON s.id = er.schueler_id
                                                        INNER JOIN belegung b ON b.schueler_id = er.schueler_id
                                                        WHERE
                                                        er.eigenschaft_id = -2
                                                        AND er.geloescht = 0
                                                        AND DATEDIFF(er.bis, er.von) > 30
                                                        AND er.von <= :von
                                                        AND er.bis >= :bis
                                                        AND er.lehrer_id IS NOT NULL    
                                                        AND s.danis_id IS NULL
                                                        AND b.beginn <= :von
                                                        AND b.ende >= :bis


                                                UNION

                                                SELECT null as id, "--> davon Schüler anderer Schulen mit 2G-Status und L1 am JAG (=Tests vom JAG) (Corona-Status > 30 Tage)", count(DISTINCT s.id) as anzahl
                                                        FROM erledigung er
                                                        INNER JOIN schueler s ON s.id = er.schueler_id
                                                        INNER JOIN belegung b ON b.schueler_id = er.schueler_id
                                                        WHERE
                                                        er.eigenschaft_id = -2
                                                        AND er.geloescht = 0
                                                        AND DATEDIFF(er.bis, er.von) > 30
                                                        AND er.von <= :von
                                                        AND er.bis >= :bis
                                                        AND er.lehrer_id IS NOT NULL    
                                                        AND s.danis_id IS NULL
                                                        AND b.gruppe_id IN (SELECT DISTINCT gruppe_id FROM schueler)
                                                        AND b.beginn <= :von
                                                        AND b.ende >= :bis
                                            

                                                UNION
                                                */

                                                SELECT null as id, "SuS mit 3 Impfungen (ohne 2 Impfungen + Genesen!)" , COUNT(DISTINCT s.id) as anzahl 
                                                FROM `erledigung` e 
                                                INNER JOIN corona_typ ct ON ct.erledigung_id = e.id 
                                                INNER JOIN schueler s on s.id = e.schueler_id 
                                                LEFT JOIN gruppe g ON g.id = s.gruppe_id 
                                                WHERE e.eigenschaft_id = -2 
                                                AND ct.corona_typen_id = 5 AND e.geloescht = 0

                                                UNION

                                                SELECT DISTINCT s.id as id, CONCAT(" (!) Nicht erfasster Schüler: ",s.vorname," ",  s.nachname, " ", IFNULL(g.name,"(ohne Stammgruppe)")) as name, 1 as anzahl
                                                    FROM schueler s
                                                    LEFT JOIN gruppe g ON g.id = s.gruppe_id
                                                    LEFT JOIN erledigung er ON (er.schueler_id = s.id AND er.eigenschaft_id=-2)
                                                    INNER JOIN belegung b ON b.schueler_id = s.id
                                                    WHERE er.id IS NULL
                                                    AND b.beginn <= :von
                                                    AND b.ende >= :bis
                                                ');


                $stmt_s = $conn->prepare('SELECT s.gruppe_id AS id, g.name AS name, SUM(m.mitteilung) AS summe
                                        FROM erledigung er
                                        LEFT JOIN schueler s ON s.id = er.schueler_id
                                        LEFT JOIN lehrer l ON (l.id = er.lehrer_id AND er.schueler_id IS NULL)
                                        INNER JOIN mitteilung m ON m.erledigung_id = er.id
                                        LEFT JOIN gruppe g ON s.gruppe_id = g.id
                                        WHERE
                                        er.eigenschaft_id = -6
                                        AND er.von >= :von
                                        AND er.von <= :bis
                                        AND m.id = (
                                                SELECT mm.id
                                                FROM mitteilung mm
                                                WHERE mm.erledigung_id = er.id
                                                ORDER BY mm.id ASC
                                                LIMIT 1
                                            )
                                        AND er.schueler_id IS NOT NULL
                                        AND s.gruppe_id IS NOT NULL
                                        AND er.geloescht = 0
                                        GROUP BY s.gruppe_id, g.name
                                        ORDER BY 2
                                        ');
                
                $stmt_gs = $conn->prepare('SELECT null AS id, IFNULL(g.name, "(ohne Stammgruppe)") AS name, SUM(m.mitteilung) AS summe
                                        FROM erledigung er
                                        LEFT JOIN schueler s ON s.id = er.schueler_id                                        
                                        INNER JOIN mitteilung m ON m.erledigung_id = er.id
                                        LEFT JOIN gruppe g ON s.gruppe_id = g.id
                                        WHERE
                                        er.eigenschaft_id = -6
                                        AND er.von >= :von
                                        AND er.von <= :bis
                                        AND m.id = (
                                                SELECT mm.id
                                                FROM mitteilung mm
                                                WHERE mm.erledigung_id = er.id
                                                ORDER BY mm.id ASC
                                                LIMIT 1
                                            )
                                        AND er.schueler_id IS NOT NULL
                                        AND s.gruppe_id IS NULL
                                        AND er.geloescht = 0
                                        GROUP BY s.gruppe_id, g.name 
                                        ORDER BY 2                                       
                                        ');
                
                
                $stmt_l = $conn->prepare('SELECT null AS gruppe_id, "Lehrer/Personal" AS name, SUM(m.mitteilung) AS summe
                                            FROM erledigung er                                            
                                            LEFT JOIN lehrer l ON l.id = er.lehrer_id 
                                            INNER JOIN mitteilung m ON m.erledigung_id = er.id                                            
                                            WHERE
                                            er.eigenschaft_id = -6
                                            AND er.von >= :von
                                            AND er.von <= :bis
                                            AND m.id = (
                                                    SELECT mm.id
                                                    FROM mitteilung mm
                                                    WHERE mm.erledigung_id = er.id
                                                    ORDER BY mm.id ASC
                                                    LIMIT 1
                                                )
                                            AND er.schueler_id IS NULL
                                            AND er.lehrer_id IS NOT NULL
                                            AND er.geloescht = 0
                                            GROUP BY 1,2                                                                                       
                                            ORDER BY 2                                           

                                            ');

                $stmt_ldetail = $conn->prepare('SELECT l.id AS gruppe_id, CONCAT("davon Lehrer/Personal ",l.kuerzel) AS name, SUM(m.mitteilung) AS summe
                                            FROM erledigung er                                            
                                            LEFT JOIN lehrer l ON l.id = er.lehrer_id 
                                            INNER JOIN mitteilung m ON m.erledigung_id = er.id                                            
                                            WHERE
                                            er.eigenschaft_id = -6
                                            AND er.von >= :von
                                            AND er.von <= :bis
                                            AND m.id = (
                                                    SELECT mm.id
                                                    FROM mitteilung mm
                                                    WHERE mm.erledigung_id = er.id
                                                    ORDER BY mm.id ASC
                                                    LIMIT 1
                                                )
                                            AND er.schueler_id IS NULL
                                            AND er.lehrer_id IS NOT NULL
                                            AND er.geloescht = 0
                                            GROUP BY 1,2                                                                                       
                                            ORDER BY 2                                           

                                            ');
                
                
                $date_von = DateTime::createFromFormat('d.m.Y', $startdatum);                
                $date_von->setTime(0,0);
                $von = $date_von->format('Y-m-d');
                
                $date_bis = DateTime::createFromFormat('d.m.Y', $startdatum);
                $date_bis->setTime(0,0);
                $date_bis->modify('+7 day');
                $bis = $date_bis->format('Y-m-d');

                $stmt_t->bindParam(':von', $von);                                
                $stmt_abit2g->bindParam(':von', $von);                                
                $stmt_s->bindParam(':von', $von);                                
                $stmt_gs->bindParam(':von', $von);                                
                $stmt_l->bindParam(':von', $von);                                
                $stmt_ldetail->bindParam(':von', $von);                                
                //$heute = date("Y-m-d");

                $stmt_t->bindParam(':bis', $bis);
                $stmt_abit2g->bindParam(':bis', $bis);
                $stmt_s->bindParam(':bis', $bis);
                $stmt_gs->bindParam(':bis', $bis);
                $stmt_l->bindParam(':bis', $bis);
                $stmt_ldetail->bindParam(':bis', $bis);
                
                $stmt_t->execute();
                $stmt_abit2g->execute();
                $stmt_s->execute();
                $stmt_gs->execute();
                $stmt_l->execute();
                $stmt_ldetail->execute();
                
                $result_t = $stmt_t->fetchAll(PDO::FETCH_ASSOC);
                $result_abit2g = $stmt_abit2g->fetchAll(PDO::FETCH_ASSOC);
                $result_s = $stmt_s->fetchAll(PDO::FETCH_ASSOC);
                $result_gs = $stmt_gs->fetchAll(PDO::FETCH_ASSOC);
                $result_l = $stmt_l->fetchAll(PDO::FETCH_ASSOC);
                $result_ldetail = $stmt_ldetail->fetchAll(PDO::FETCH_ASSOC);

                $info=array();
                $info[] = array("id"=>null, "name"=>"Corona-Testausgabe Wochenstatistik von ", "datum" => $date_von->format('d.m.Y H:i:s'));
                $info[] = array("id"=>null, "name"=>"Corona-Testausgabe Wochenstatistik bis ", "datum" => $date_bis->format('d.m.Y H:i:s'));
                $info[] = array("id"=>null, "name"=>"erstellt am ", "datum" => Date("d.m.Y H:i:s"));
                $info[] = array("id"=>null, "name"=>"erstellt durch User mit lehrer_id ", "datum" => $_SESSION['user_lehrer_id']);
                
                $result = array_merge($info, 
                                        $result_t, 
                                        $result_abit2g,                                         
                                        $result_s, 
                                        $result_gs, 
                                        $result_l, 
                                        $result_ldetail
                                    );

                // one-to-one

                // many-to-one
                
                //Statements für das Zulesen der Mitteilungen und Zustimmungen zu einer Erledigung
                                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }


        public static function read_all() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM erledigung WHERE geloescht = 0');
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT er.*,l.kuerzel AS lehrer_kuerzel
                                        FROM erledigung er 
                                        LEFT JOIN lehrer l ON l.id = er.lehrer_id
                                        WHERE er.id = :id AND er.geloescht = 0');
                
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

               
                if($result['id'] && $result['eigenschaft_id']==-3 ){
                    Erledigung::update_zustimmung($id);
                }


                $stmt_mt = $conn->prepare('SELECT * FROM mitteilung WHERE erledigung_id = :id AND geloescht = 0 ORDER BY created_at DESC');
                $stmt_mt->bindParam(':id', $id);
                $stmt_mt->execute();
                $result_mt = $stmt_mt->fetchALL(PDO::FETCH_ASSOC);

                $result['mitteilung'] = $result_mt;

                $stmt_mt = $conn->prepare('SELECT * FROM schueler WHERE id = :id');
                $stmt_mt->bindParam(':id', $result["schueler_id"]);
                $stmt_mt->execute();
                $result_mt = $stmt_mt->fetch(PDO::FETCH_ASSOC);

                $result['schueler'] = $result_mt;

                $stmt_mt = $conn->prepare('SELECT * FROM eigenschaft WHERE id = :id');
                $stmt_mt->bindParam(':id', $result["eigenschaft_id"]);
                $stmt_mt->execute();
                $result_mt = $stmt_mt->fetch(PDO::FETCH_ASSOC);

                $result['eigenschaft'] = $result_mt;

                $stmt_zs = $conn->prepare("SELECT zs.*, l.kuerzel
                                            FROM zustimmung zs
                                            LEFT JOIN lehrer l ON l.id = zs.lehrer_id
                                            WHERE zs.erledigung_id = :er_id
                                            AND zs.geloescht = 0                                        
                                            ");
                $stmt_zs->bindParam(':er_id', $result['id']);
                $stmt_zs->execute();
                $result['zustimmung'] = $stmt_zs->fetchAll(PDO::FETCH_ASSOC);
                $offen = 0;
                $offen_gruppe = 0;
                foreach($result['zustimmung'] as $zustimmung){
                    if($zustimmung['zustimmung']==0){
                        $offen++;
                        if($zustimmung['gruppe_id']!=null){
                            $offen_gruppe++;
                        }
                    }
                }
                $result['zustimmung_offen'] = $offen;
                $result['zustimmung_gruppe_offen'] = $offen_gruppe;

                
                //Statement für das Zulesen des Corona-Typs, falls id=-2
                $stmt_ct = $conn->prepare("SELECT ct.id as id, ctn.name, ctn.id as corona_typen_id
                                           FROM corona_typ ct
                                           INNER JOIN corona_typen ctn ON ctn.id = ct.corona_typen_id
                                           WHERE
                                           ct.erledigung_id = :er_id
                                           AND ct.geloescht = 0
                                           AND ctn.geloescht  = 0
                                           ");
                if($result['eigenschaft_id']==-2){
                    $stmt_ct->bindParam(':er_id', $result['id']);
                    $stmt_ct->execute();
                    $result['corona_typ'] = $stmt_ct->fetch(PDO::FETCH_ASSOC);  
                }

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }




        /**
         * gruppenbezogene Ausgabe aller Erledigungen zu einer Eigenschaft
         * 
         */
        public static function read_entschuldigung_aktuell_by_gruppe($gruppe_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT s.*, b.beginn, b.ende, b.id AS belegung_id, IF(b.beginn<= :heute AND b.ende >= :heute, 1, 0) AS belegung_jetzt
                                        FROM schueler s
                                        INNER JOIN belegung b ON b.schueler_id = s.id 
                                        WHERE   b.gruppe_id = :id   
										AND 	b.beginn <= :heute
										AND		b.ende >= :heute
                                        ORDER BY s.nachname, s.vorname');
                
                $stmt->bindParam(':id', $gruppe_id);                                
                $heute = date("Y-m-d H:i:s");
                $stmt->bindParam(':heute', $heute);
                
                $stmt->execute();
                $schueler = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                $result = array();
                $stmt_er = $conn->prepare(' SELECT er.*, l.kuerzel AS lehrer_kuerzel
                                            FROM erledigung er
                                            LEFT JOIN lehrer l ON l.id = er.lehrer_id
                                            WHERE
                                                er.eigenschaft_id IN (-3,-4,-5)
                                                AND er.schueler_id = :schueler_id
                                                AND er.geloescht = 0
                                                AND er.von <= :heute
                                                AND (er.bis >= :heute OR er.bis IS NULL)
                                            ORDER BY er.id DESC');
                                        

                foreach ($schueler as $row){
                                        
                    $stmt_er->bindParam(':schueler_id', $row['id']);
                    $stmt_er->bindParam(':heute', $heute);

                    $stmt_er->execute();
                    $res_er = $stmt_er->fetchAll(PDO::FETCH_ASSOC);

                    //Optional hier noch zulesen der Mitteilungen zu dieser Erledigung
                    $row['zustimmung'] = array();
                    $row['zustimmung_offen'] = 0;
                    $row['mitteilung'] = array(); 


                    $row['erledigung'] = $res_er;
                    array_push($result, $row);
                }

                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }





        /**
         * Fehlzeitenübersicht eines Schülers
         * 
         */
        public static function read_fehlzeitenuebersicht($schueler_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT  u.id AS unterricht_id, 
                                                u.datum,
                                                u.ustunde_id,
                                                u.lehrer_id,
                                                l.kuerzel,
                                                us.beginn,
                                                us.ende,
                                                us.block,
                                                g.id AS gruppe_id,
                                                g.name AS gruppe,
                                                f.kurz AS fach,
                                                p.id AS praesenz_id,
                                                p.fehlt,
                                                er.id AS erledigung_id,
                                                er.lehrer_id AS erledigung_lehrer_id,
                                                er.eigenschaft_id,
                                                er.von,
                                                er.bis 
                                                
                                                FROM belegung b
                                                INNER JOIN unterricht u ON (
                                                                            u.gruppe_id = b.gruppe_id
                                                                            AND u.datum >= b.beginn
                                                                            AND u.datum <= b.ende
																			AND u.geloescht = 0
                                                                            )
                                                INNER JOIN gruppe g ON (g.id = u.gruppe_id)
                                                
                                                LEFT JOIN lehrer l ON l.id = u.lehrer_id

                                                INNER JOIN ustunde us ON (us.id = u.ustunde_id)

                                                INNER JOIN fach f ON (f.id = u.fach_id)

                                                LEFT OUTER JOIN praesenz p ON (
                                                                            p.unterricht_id = u.id
                                                                            AND p.belegung_id = b.id                                                           
                                                                            )                       

                                                LEFT OUTER JOIN erledigung er ON (
                                                                            er.eigenschaft_id IN (-3,-4,-5)
                                                                            AND er.schueler_id = b.schueler_id
                                                                            AND er.von <= TIMESTAMP(u.datum,us.beginn)
                                                                            AND (er.bis >= TIMESTAMP(u.datum,us.beginn) OR er.bis IS NULL)
                                                                            AND er.geloescht = 0
                                                )                         
                           
                                                WHERE
                                                b.schueler_id = :schueler_id

                                                ORDER BY u.datum DESC, us.beginn ASC
                                                
                                                ');
                
                $stmt->bindParam(':schueler_id', $schueler_id);                                
                
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }



        //Ermittelt alle offenen Erledigungen in der Lerngruppe, welche auf der Startseite angezeigt
        //werden sollen. Gruppierung nach der Eigenschaft.
        public static function read_erledigung_startseite_by_gruppe($idg){
            try {
                $db = new DB();
                $conn = $db->connect();
                
                $stmt = $conn->prepare('SELECT DISTINCT
                                        ei.id AS eigenschaft_id,
                                        ei.name AS eigenschaft_name,
                                        ei.regel AS eigenschaft_regel,
                                        ei.onclick AS eigenschaft_onclick
                                        FROM belegung b
                                        INNER JOIN schueler s ON 
                                            (s.id = b.schueler_id AND s.geloescht = 0)
                                        INNER JOIN erledigung er ON 
                                            (er.schueler_id = s.id AND er.geloescht = 0)
                                        INNER JOIN eigenschaft ei ON
                                            (ei.id = er.eigenschaft_id 
                                            AND ei.geloescht = 0 
                                            AND ei.startseite = 1
                                            AND (ei.lehrer_id IS NULL OR ei.lehrer_id = :lehrer_id)
                                            )
                                        WHERE
                                        b.gruppe_id = :gruppe_id
                                        AND b.beginn <= :heute
                                        AND b.ende >= :heute                                       
                                        ORDER BY ei.id        
                                        ');
                
                $stmt->bindParam(':gruppe_id', $idg);
                $heute = date("Y-m-d H:i:s");
                $stmt->bindParam(':heute', $heute);
                $idl = $_SESSION['user_lehrer_id'];
                $stmt->bindParam(':lehrer_id', $idl);
                
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                
                // one-to-many 
                $stmt = $conn->prepare('SELECT
                                        s.vorname,
                                        s.nachname,
                                        s.id AS schueler_id,
                                        er.id AS erledigung_id,
                                        er.von AS erledigung_von,
                                        er.bis AS erledigung_bis,
                                        er.lehrer_id AS erledigung_lehrer_id
                                        FROM erledigung er
                                        INNER JOIN schueler s ON 
                                            (s.id = er.schueler_id 
                                            AND s.geloescht = 0)
                                        INNER JOIN belegung b ON
                                            (b.schueler_id = s.id
                                            AND b.beginn <= :heute
                                            AND b.ende >= :heute
                                            AND b.gruppe_id = :gruppe_id)                                                                              
                                        
                                        WHERE                                        
                                        er.eigenschaft_id = :eigenschaft_id
                                        AND
                                        er.geloescht = 0
                                        
                                        AND

                                        (
                                            (:eigenschaft_regel = 2 
                                            AND er.lehrer_id IS NULL
                                            )
                                        OR
                                            (:eigenschaft_regel = 1
                                            AND er.lehrer_id IS NULL
                                            AND er.von <= :heute
                                            AND er.bis >= :heute
                                            )
                                        OR
                                            (:eigenschaft_regel = 0
                                            AND NOT EXISTS (
                                                        SELECT eer.id 
                                                        FROM erledigung eer
                                                        WHERE
                                                            eer.schueler_id = s.id
                                                            AND eer.eigenschaft_id = :eigenschaft_id
                                                            AND eer.von <= :heute
                                                            AND eer.geloescht = 0
                                                            AND eer.lehrer_id IS NOT NULL 
                                                            AND eer.bis >= :heute
                                                        ORDER BY eer.bis DESC
                                                        LIMIT 1
                                                        )
                                            AND er.id = (
                                                        SELECT eer.id 
                                                        FROM erledigung eer
                                                        WHERE
                                                            eer.schueler_id = s.id
                                                            AND eer.eigenschaft_id = :eigenschaft_id
                                                            AND eer.von <= :heute
                                                            AND eer.geloescht = 0                                                                                                                        
                                                        ORDER BY eer.bis DESC
                                                        LIMIT 1
                                                        )
                                            )
                                        )
                                        ORDER BY nachname, vorname
                                        
                                        ');
                
                $stmt->bindParam(':gruppe_id', $idg);
                $heute = date("Y-m-d H:i:s");
                $stmt->bindParam(':heute', $heute);
                
                $res = array();
                foreach ($result AS $eigenschaft){
                    
                    $stmt->bindParam(':eigenschaft_id', $eigenschaft['eigenschaft_id']);
                    $stmt->bindParam(':eigenschaft_regel', $eigenschaft['eigenschaft_regel']);
                    
                    $stmt->execute();
                    
                    $lis = array();

                    $lis['eigenschaft'] = $eigenschaft;
                    $lis['erledigung'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $res[] = $lis;
    
                }
                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($res);;
        }


        //Ermittelt die von einer Erledigung betroffenen Unterrichte und trägt
        //für deren Lehrkräfte eine Zustimmungsabgabe ein.        
        public static function update_zustimmung($id){
            try {
                $db = new DB();
                $conn = $db->connect();
                
                //Ermitteln der Lehrer-IDs der von der Erledigung betroffenen Unterrichte.
                //->Von und Bis-Datum der Erledigung müssen gesetzt sein, 
                //->die Erledigung darf noch nicht signiert sein.
                //->der Schüler muss aus der Sek. II sein <=> eine Apollon-ID haben
                //->es muss sich um eine Entschuldigung (Eigenschaft-ID = -3) handeln
                //->es muss sich um Zustimmung von Kurslehrkräften handeln (=>Gruppe_id != null)
                //SELECT u.datum, us.beginn, us.ende, g.name, l.kuerzel 
                // 10.01.22: alte Join-Bedingung für belegung: AND (b.beginn <= er.von OR b.ende >= er.bis)
                $stmt = $conn->prepare('SELECT DISTINCT l.id, g.name, g.id as gruppe_id, l.kuerzel, COUNT(u.id) AS unterricht_count
                                        FROM erledigung er
                                        
                                        LEFT JOIN belegung b ON (
                                                                b.schueler_id = er.schueler_id
                                                                AND (er.bis >= b.beginn AND er.von <= b.ende)
                                                                )                                        
                                        LEFT JOIN (unterricht u INNER JOIN ustunde us ON u.ustunde_id = us.id)
                                                                ON (
                                                                u.gruppe_id = b.gruppe_id
                                                                AND u.geloescht = 0                                                                
                                                                AND er.von <= TIMESTAMP(u.datum,us.beginn)
                                                                AND er.bis >= TIMESTAMP(u.datum,us.beginn) 
                                                                AND er.bis IS NOT NULL
                                                                AND er.von IS NOT NULL
                                                                )
                                        INNER JOIN gruppe g ON g.id = u.gruppe_id
                                        INNER JOIN lehrer l ON l.id = u.lehrer_id
                                        INNER JOIN schueler s ON er.schueler_id = s.id
                                        
                                        WHERE
                                        er.lehrer_id IS NULL
                                        AND er.id = :er_id
                                        AND s.apollon_id IS NOT NULL
                                        AND er.eigenschaft_id = -3
                                        GROUP BY l.id, gruppe_id
                                        ');
                $stmt->bindParam(':er_id', $id);      
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Lesen der bereits eingetragenen Zustimmungen
                $stmt_zs = $conn->prepare('SELECT z.*
                                            FROM zustimmung z
                                            WHERE
                                            z.erledigung_id = :er_id
                                            AND
                                            z.geloescht = 0   
                                            AND
                                            z.gruppe_id IS NOT NULL                                         
                                          ');
                $stmt_zs->bindParam(':er_id', $id);      
                $stmt_zs->execute();
                $zustimmung = $stmt_zs->fetchAll(PDO::FETCH_ASSOC);
                

                //Einzufügende Zustimmungen                
                foreach ($result as $lehrer){
                    $lehrer_id = $lehrer['id'];
                    $vorhanden = false;
                    
                    foreach($zustimmung as $zs){
                        if($zs['lehrer_id']==$lehrer_id && $lehrer['gruppe_id']==$zs['gruppe_id']){
                            $vorhanden = true;
                        }
                    }

                    if($vorhanden == false){
                        $data = array();
                        $data['erledigung_id'] = $id;
                        $data['lehrer_id'] = $lehrer_id;
                        $data['gruppe_id'] = $lehrer['gruppe_id'];
                        $data['info'] = $lehrer['name'].' ('.$lehrer['unterricht_count'].'x)';
                        
                        $query = DB::create_insert_query('zustimmung', $data);
                        $stmt_ins = $conn->prepare($query);
                        $stmt_ins->bindValue(':erledigung_id', $id);
                        $stmt_ins->bindValue(':lehrer_id', $lehrer_id);
                        $stmt_ins->bindValue(':gruppe_id', $lehrer['gruppe_id']);
                        $stmt_ins->bindValue(':info', $data['info']);
                        $stmt_ins->execute();
                    }
                }

                //zu löschende Zustimmungen (Soft-Delete)                
                foreach($zustimmung as $zs){
                    $vorhanden = false;
                    $lehrer_id = $zs['lehrer_id'];
                    foreach($result as $lehrer){
                        if($lehrer['id']==$lehrer_id && $lehrer['gruppe_id'] == $zs['gruppe_id']){
                            $vorhanden = true;
                        }
                    }
                    if($vorhanden == false){
                        $data = array();
                        $data['geloescht'] = 1;
                        
                        $query = DB::create_update_query('zustimmung', $data);                    
                        $stmt_upd = $conn->prepare($query);
                        $stmt_upd->bindValue(':geloescht', 1);
                        $stmt_upd->bindValue(':id', $zs['id']);
                        $stmt_upd->execute();
                    }
                }


                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);          
        }


        

    }

?>