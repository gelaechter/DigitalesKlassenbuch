<?php
    class Schueler {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT s.*, l.kuerzel AS tutor_kuerzel, l.id AS tutor_id 
                                        FROM schueler s
                                        LEFT JOIN gruppe g ON g.id = s.gruppe_id
                                        LEFT JOIN lehrer l ON l.id = g.lehrer_id
                                        WHERE s.id = :id');
                $stmt->bindParam(':id', $id);
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
                $stmt = $conn->prepare('SELECT * FROM belegung WHERE schueler_id = :schueler_id');
                $stmt->bindParam(':schueler_id', $id);
                $stmt->execute();
                $beleg = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['belegung'] = $beleg;

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }


        public static function read_by_rfid($rfid) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT qry.rfid, rf.schueler_id, rf.lehrer_id, IFNULL(g.id,b.gruppe_id) AS gruppe_id
                                        FROM (SELECT :rfid AS rfid) qry
                                        LEFT JOIN rfid rf ON rf.rfid = :rfid
                                        LEFT JOIN lehrer l ON l.id = rf.lehrer_id
                                        LEFT JOIN schueler s ON s.id = rf.schueler_id
                                        LEFT JOIN gruppe g ON g.id = s.gruppe_id
                                        LEFT JOIN belegung b ON (
                                            b.schueler_id = rf.schueler_id
                                            AND b.beginn <= :heute
                                            AND b.ende >= :heute
                                            )                                        
                                        LIMIT 1
                                        ');
                
                if($rfid=="demo"){
                    $stmt = $conn->prepare('SELECT :rfid as rfid, b.schueler_id, null as lehrer_id, b.gruppe_id
                                            FROM belegung b
                                            WHERE
                                            b.beginn <= :heute
                                            AND b.ende >= :heute

                                            UNION

                                            SELECT :rfid as rfid, null as schueler_id, l.id as lehrer_id, null as gruppe_id
                                            FROM lehrer l

                    ');

                    $stmt->bindParam(':rfid', strval($rfid));
                    $heute = date('Y-m-d');
                    $stmt->bindParam(':heute', $heute);                
                    $stmt->execute();

                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $key = array_rand($results, 1);
                    $result = $results[$key];


                } else {
                    $stmt->bindParam(':rfid', strval($rfid));
                    $heute = date('Y-m-d');
                    $stmt->bindParam(':heute', $heute);                
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
                if ($result['schueler_id']) {
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

        public static function read_all() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM schueler');
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');

                foreach ($data as $row) {

                    // many-to-one
                    if ($row['gruppe_id']) {
                        $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                        $stmt_g->execute();
                        $gru = $stmt_g->fetch(PDO::FETCH_ASSOC);
                        $row['gruppe'] = $gru;
                    }

                    array_push($result, $row);
                }

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }
    }
?>