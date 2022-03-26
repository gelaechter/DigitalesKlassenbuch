<?php
    class Eingeschraenkt {
       
        public static function gruppe_read_all() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT g.*                                         
                                        FROM gruppe g 
                                        INNER JOIN belegung b ON (b.gruppe_id = g.id AND b.schueler_id = :s_id)
                                        WHERE g.geloescht = 0                                        
                                        ');

                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


                $result = array();
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');

                foreach ($data as $row) {
                    // many-to-one
                    if ($row['lehrer_id']) {
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $leh;
                    }
                    array_push($result, $row);
                }

                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }



        public static function gruppe_read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM gruppe WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);


                // one-to-one

                // many-to-one
                if ($result['lehrer_id']) {
                    $stmt = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                    $stmt->bindParam(':lehrer_id', $result['lehrer_id']);
                    $stmt->execute();
                    $grp = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['lehrer'] = $grp;
                }

                // one-to-many

                // Belegung der Unterrichte durch Schueler
                // Die Daten muessen in der gleichen Form, wie die 
                // Praesenz-Daten bei den Unterrichten gelesen werden
                $stmt = $conn->prepare('SELECT * FROM belegung WHERE gruppe_id = :gruppe_id AND schueler_id = :s_id');
                $stmt->bindParam(':gruppe_id', $id);
                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);
                $stmt->execute();
                $belegungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if(sizeof($belegungen)==0){
                    return '{}';
                }

                // Schuelerdaten zu den Belegungen hinzulesen
                $beleg = array();
                $stmt_s = $conn->prepare('SELECT * FROM schueler WHERE id = :schueler_id');
                foreach ($belegungen as $row) {
                    if ($row['schueler_id']) {
                        $stmt_s->bindParam(':schueler_id', $row['schueler_id']);
                        $stmt_s->execute();
                        $sch = $stmt_s->fetch(PDO::FETCH_ASSOC);
                        $row['schueler'] = $sch;
                    }
                    array_push($beleg, $row);
                }

                $result['belegung'] = $beleg;

                // Schueler, die diese Lerngruppe als Klasse/Tutoriat haben
                $stmt = $conn->prepare('SELECT * FROM schueler WHERE gruppe_id = :gruppe_id AND id = :s_id');
                $stmt->bindParam(':gruppe_id', $id);
                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);

                $stmt->execute();
                $schueler = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['schueler'] = $schueler;

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }
       

        public static function schueler_read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT s.*, l.kuerzel AS tutor_kuerzel, l.id AS tutor_id 
                                        FROM schueler s
                                        LEFT JOIN gruppe g ON g.id = s.gruppe_id
                                        LEFT JOIN lehrer l ON l.id = g.lehrer_id
                                        WHERE s.id = :id AND s.id = :s_id');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                //UL als Tutor von Schülern ohne Tutor
                if(!$result['tutor_id']){
                    $result['tutor_id']=39;
                    $result['tutor_kuerzel']='(UL)';
                }
                
                // one-to-one

                // many-to-one
                if ($result['gruppe_id']) {
                    $stmt = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                    $stmt->bindParam(':gruppe_id', $result['gruppe_id']);
                    $stmt->execute();
                    $grp = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['gruppe'] = $grp;
                }

                // one-to-many
                if($_SESSION['user_schueler_id'] == $id){
                    $stmt = $conn->prepare('SELECT * FROM belegung WHERE schueler_id = :schueler_id');
                    $stmt->bindParam(':schueler_id', $id);
                    $stmt->execute();
                    $beleg = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result['belegung'] = $beleg;
                }

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
        public static function erledigung_read_by_schueler($schueler_id, $eigenschaft_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                
                $stmt_er = $conn->prepare(' SELECT er.*, l.kuerzel AS lehrer_kuerzel
                FROM erledigung er
                LEFT JOIN lehrer l ON l.id = er.lehrer_id
                WHERE
                    er.eigenschaft_id = :eigenschaft_id
                    AND er.schueler_id = :schueler_id
                    AND er.schueler_id = :s_id
                    AND er.geloescht = 0
                    AND er.eigenschaft_id IN (-3,-4,-5)
                ORDER BY er.id DESC');

                $stmt_er->bindParam(':eigenschaft_id', $eigenschaft_id);
                $stmt_er->bindParam(':schueler_id', $schueler_id);
                $stmt_er->bindParam(':s_id', $_SESSION['user_schueler_id']);

                $stmt_er->execute();
                $erledigung = $stmt_er->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                
                $result = array();
                
                //Zulesen der Mitteilungen und Zustimmungen zu dieser Erledigung
                $stmt_mt = $conn->prepare("SELECT mitteilung, created_at FROM mitteilung WHERE erledigung_id = :er_id");
                $stmt_zs = $conn->prepare("SELECT zs.*, l.kuerzel
                                           FROM zustimmung zs
                                           INNER JOIN lehrer l ON l.id = zs.lehrer_id
                                           WHERE zs.erledigung_id = :er_id
                                           AND zs.geloescht = 0                                        
                                           ");

                foreach ($erledigung as $row){         
                    $stmt_mt->bindParam(':er_id', $row['id']);
                    $stmt_mt->execute();
                    $row['mitteilung'] = $stmt_mt->fetchAll(PDO::FETCH_ASSOC);
                        
                    if($row['eigenschaft_id']==-3){
                        Erledigung::update_zustimmung($row['id']);
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
                
                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }

       


         /**
         * Fehlzeitenübersicht eines Schülers
         * 
         */
        public static function erledigung_read_fehlzeitenuebersicht($schueler_id) {
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
                                                AND
                                                b.schueler_id = :s_id
												

                                                ORDER BY u.datum DESC, us.beginn ASC
                                                
                                                ');
                
                $stmt->bindParam(':schueler_id', $schueler_id); 
                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);

                
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



        public static function erledigung_read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * 
                                        FROM erledigung er 
                                        WHERE er.id = :id 
                                        AND er.geloescht = 0 
                                        AND er.schueler_id = :s_id
                                        AND er.eigenschaft_id IN (-3,-4,-5)
                                        ');
                
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':s_id', $_SESSION['user_schueler_id']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if($result['id'] && $result['eigenschaft_id']==-3 ){
                    Erledigung::update_zustimmung($id);
                }
                
                
                $stmt_mt = $conn->prepare('SELECT * FROM mitteilung WHERE erledigung_id = :id AND geloescht = 0 ORDER BY created_at DESC');
                $stmt_mt->bindParam(':id', $result['id']);
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
                
                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }




       
       
       
    }
?>