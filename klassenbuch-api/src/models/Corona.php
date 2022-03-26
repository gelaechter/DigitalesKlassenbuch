<?php
    class Corona {
        
        public static function read_by_gruppe($id) {
            /*
            try {
               
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT er.id, s.vorname, s.nachname, er.von, er.bis, ct.corona_typen_id, ct.id as corona_typ_id 
                                        FROM erledigung er 
                                        LEFT JOIN corona_typ ct ON (ct.erledigung_id = er.id AND ct.geloescht = 0 )
                                        INNER JOIN belegung b ON b.schueler_id = er.schueler_id 
                                        INNER JOIN schueler s ON s.id = er.schueler_id  
                                        WHERE b.gruppe_id = :id 
                                            AND er.eigenschaft_id=-2 
                                            AND b.beginn <= :heute 
                                            AND b.ende >= :heute 
                                            AND er.geloescht = 0
                                            AND er.id = (
                                                        SELECT eer.id 
                                                        FROM erledigung eer
                                                        WHERE
                                                            eer.schueler_id = s.id
                                                            AND eer.eigenschaft_id = -2
                                                            AND eer.von <= :heute
                                                            AND eer.geloescht = 0
                                                        ORDER BY eer.bis DESC
                                                        LIMIT 1
                                                        )
                                        ORDER BY s.nachname, s.vorname');
                $stmt->bindParam(':id', $id);
                
                $heute = date("Y-m-d");
                $stmt->bindParam(':heute', $heute);
                
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one

                // one-to-many                

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            */

            $sus = json_decode(Erledigung::read_by_gruppe($id, -2), true);
            //SELECT er.id, s.vorname, s.nachname, er.von, er.bis, ct.corona_typen_id, ct.id as corona_typ_id 

            $heute = date("Y-m-d");
            $result = array();
            foreach($sus as $daten){
                
                if ($daten['beginn']<= $heute && $daten['ende']>= $heute) {
                    $data = array();
                    $gefunden = true;
                    $data = array( 
                        "id" => -1,
                        "schueler_id" => $daten['id'],
                        "vorname" => $daten['vorname'],
                        "nachname" => $daten['nachname'],
                        "von" => date("Y-m-d H:i:s",strtotime("-2 day")),
                        "bis" => date("Y-m-d H:i:s", strtotime("-1 day")),
                        "corona_typen_id" => 1
                        );

                    foreach($daten['erledigung'] as $er){
                        
                        $ctn_id = -1;
                        if($er['corona_typ']){
                            $ctn_id = $er['corona_typ']['corona_typen_id'];
                        } elseif(isset($er['ersatz_corona_typen_id'])) {
                            $ctn_id = $er['ersatz_corona_typen_id'];
                        }

                        if($er['corona_status']==true){
                            $gefunden = false;
                        }
                        
                        if($er['corona_testpflicht']==true && $ctn_id ==1){
                            if($data['id']==-1 || $data['von'] < $er['von']){
                                $data = array( 
                                    "id" => $er['id'],
                                    "schueler_id" => $daten['id'],
                                    "vorname" => $daten['vorname'],
                                    "nachname" => $daten['nachname'],
                                    "von" => $er['von'],
                                    "bis" => $er['bis'],
                                    "corona_typen_id" => $ctn_id
                                    );
                            }

                        }
                    }
                    
                    if($gefunden==true){
                        $result[]= $data;
                    }

                }

            }

            return json_encode($result);;
        }

        public static function read_all() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT er.id, s.vorname, s.nachname, s.gruppe_id, er.von, er.bis,  ct.corona_typen_id, ct.id as corona_typ_id 
                                        FROM erledigung er
                                        LEFT JOIN corona_typ ct ON (ct.erledigung_id = er.id AND ct.geloescht = 0)
                                        INNER JOIN schueler s ON s.id = er.schueler_id 
                                        INNER JOIN eigenschaft ei ON ei.id = er.eigenschaft_id 
                                        WHERE   ei.id = -2 
                                                AND er.geloescht = 0 
                                        ORDER BY s.gruppe_id, s.nachname, s.vorname');
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
                $stmt = $conn->prepare('SELECT er.id, s.vorname, s.nachname, s.gruppe_id, er.von, er.bis , ct.corona_typen_id, ct.id as corona_typ_id 
                                        FROM erledigung er 
                                        LEFT JOIN corona_typ ct ON (ct.erledigung_id = er.id AND ct.geloescht = 0 )
                                        INNER JOIN schueler s ON s.id = er.schueler_id 
                                        INNER JOIN eigenschaft ei ON ei.id = er.eigenschaft_id 
                                        WHERE 
                                            er.id = :id
                                            AND er.geloescht = 0');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


        public static function read_corona_typen() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT *
                                        FROM corona_typen
                                        WHERE
                                        geloescht = 0');

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


        public static function count_geimpfte($endtag) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT count(er.id) AS Personenanzahl, :endtag AS status_bis_mindestens, :heute as status_ab_spaetestens
                                        FROM erledigung er                                         
                                        WHERE 
                                            er.eigenschaft_id = -2
                                            AND er.von <= :heute
                                            AND er.bis >= :endtag
                                            AND er.geloescht = 0');
                $stmt->bindParam(':id', $id);
                $heute = date("Y-m-d H:i:s");
                $stmt->bindParam(':heute', $heute);                
                $stmt->bindParam(':endtag', $endtag);

                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


        public static function checkCoronaStatus($erledigungen){
            
            $regel_genesen_zweiImpfungen_impfung = -1;
            $regel_genesen_zweiImpfungen_genesung = -1;

            foreach($erledigungen as $er_key=>$er_data){

                $von = $erledigungen[$er_key]['von'];
                $bis = $erledigungen[$er_key]['bis'];
                $heute = date('Y-m-d H:i:s');
                $heute_minus90d = date('Y-m-d H:i:s', strtotime("-90 day"));


                $erledigungen[$er_key]['corona_status'] = false;
                $erledigungen[$er_key]['corona_testpflicht'] = true;


                 $ct = $er_data['corona_typ'];
                 if(!$ct){                    

                    $datetime1 = new DateTime($von);
                    $datetime2 = new DateTime($bis);                    
                    $difference = $datetime1->diff($datetime2);
                    //$erledigungen[$er_key]['corona_daycount'] = $difference->format("%a");

                    if ($difference->format("%a") > 30){
                       $corona_typen_id  = 4;
                    } else {
                       $corona_typen_id  = 1;
                    }          
                    $erledigungen[$er_key]['ersatz_corona_typen_id'] = $corona_typen_id;          

                 } else {
                     $corona_typen_id = $erledigungen[$er_key]['corona_typ']['corona_typen_id'];
                 }

                
                //Laienschnelltest
                 if($corona_typen_id == 1 && $von <= $heute && $bis >= $heute){
                    $erledigungen[$er_key]['corona_status'] = true;
                }

                //Booster-Impfung
                if($corona_typen_id == 5 && $von <= $heute){
                    $erledigungen[$er_key]['corona_status'] = true;
                    $erledigungen[$er_key]['corona_testpflicht'] = false;
                }

                //Genesen + 2-fach-geimpft
                if($corona_typen_id == 2 && $von <= $heute ){  //&& $von >= $heute_minus90d
                    $regel_genesen_zweiImpfungen_genesung = $er_key;
                    $erledigungen[$er_key]['corona_2ig_g'] = $regel_genesen_zweiImpfungen_genesung;
                }
                if($corona_typen_id == 4 && $von <= $heute){
                    $regel_genesen_zweiImpfungen_impfung = $er_key;
                    $erledigungen[$er_key]['corona_2ig_i'] = $regel_genesen_zweiImpfungen_impfung;
                }
            }

             //Genesen + 2-fach-geimpft
             if( $regel_genesen_zweiImpfungen_impfung>=0 &&  $regel_genesen_zweiImpfungen_genesung>=0){
                $erledigungen[$regel_genesen_zweiImpfungen_impfung]['corona_status'] = true;
                $erledigungen[$regel_genesen_zweiImpfungen_impfung]['corona_testpflicht'] = false;
                $erledigungen[$regel_genesen_zweiImpfungen_genesung]['corona_status'] = true;
                $erledigungen[$regel_genesen_zweiImpfungen_genesung]['corona_testpflicht'] = false;
            }

            return $erledigungen;
            
        }

    }
?>