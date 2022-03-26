<?php
    class Unterricht {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM unterricht WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                $stmt_us = $conn->prepare('SELECT * FROM ustunde WHERE id = :ustunde_id');
                $stmt_f = $conn->prepare('SELECT * FROM fach WHERE id = :fach_id');

                if ($result['gruppe_id']) {
                    $stmt_g->bindParam(':gruppe_id', $result['gruppe_id']);
                    $stmt_g->execute();
                    $grp = $stmt_g->fetch(PDO::FETCH_ASSOC);
                    $result['gruppe'] = $grp;
                }
                
                if ($result['lehrer_id']) {
                    $stmt_l->bindParam(':lehrer_id', $result['lehrer_id']);
                    $stmt_l->execute();
                    $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                    $result['lehrer'] = $leh;
                }
                
                if ($result['ustunde_id']) {
                    $stmt_us->bindParam(':ustunde_id', $result['ustunde_id']);
                    $stmt_us->execute();
                    $ustd = $stmt_us->fetch(PDO::FETCH_ASSOC);
                    $result['ustunde'] = $ustd;
                }
                
                if ($result['fach_id']) {
                    $stmt_f->bindParam(':fach_id', $result['fach_id']);
                    $stmt_f->execute();
                    $fach = $stmt_f->fetch(PDO::FETCH_ASSOC);
                    $result['fach'] = $fach;
                }


                // one-to-many

                // Praesenzen zum Unterricht mit der zugehoerigen Belegung un den Schuelerdaten lesen
                // fehlende Praesenzen muessen auch mit ausgegebenm werden
                $stmt = $conn->prepare('SELECT * FROM praesenz_ist
                    WHERE unterricht_id = :unterricht_id_1
                    UNION DISTINCT SELECT * FROM praesenz_soll
                    WHERE unterricht_id = :unterricht_id_2
                    AND ende >= :u_datum
                    AND beginn <= :u_datum
                    ORDER BY nachname, vorname');

                $stmt->bindParam(':unterricht_id_1', $id);
                $stmt->bindParam(':unterricht_id_2', $id);
                $stmt->bindParam(':u_datum', $result['datum']);
                $stmt->execute();
                $praesenzen = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result['praesenzen'] = $praesenzen;

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
                $stmt = $conn->prepare('SELECT * FROM unterricht');
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                $stmt_us = $conn->prepare('SELECT * FROM ustunde WHERE id = :ustunde_id');
                $stmt_f = $conn->prepare('SELECT * FROM fach WHERE id = :fach_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['gruppe_id']) {
                        $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                        $stmt_g->execute();
                        $grp = $stmt_g->fetch(PDO::FETCH_ASSOC);
                        $row['gruppe'] = $grp;
                    }
                    
                    if ($row['lehrer_id']) {
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $leh;
                    }
                    
                    if ($row['ustunde_id']) {
                        $stmt_us->bindParam(':ustunde_id', $row['ustunde_id']);
                        $stmt_us->execute();
                        $ustd = $stmt_us->fetch(PDO::FETCH_ASSOC);
                        $row['ustunde'] = $ustd;
                    }
                    
                    if ($row['fach_id']) {
                        $stmt_f->bindParam(':fach_id', $row['fach_id']);
                        $stmt_f->execute();
                        $fach = $stmt_f->fetch(PDO::FETCH_ASSOC);
                        $row['fach'] = $fach;
                    }
                    
                    array_push($result, $row);
                }

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
                
            return json_encode($result);;
        }

        // spezielle Abfragen fuer das Klassenbuch
        // Abfrage eine Gruppe ueber eine Woche 
        public static function read_by_gruppe_von_bis($gruppe_id, $datum_von, $datum_bis) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT u.* FROM unterricht u 
                    LEFT OUTER JOIN ustunde us ON (us.id = u.ustunde_id)
                    WHERE u.gruppe_id = :gruppe_id 
                    AND u.datum BETWEEN :datum_von AND :datum_bis 
                    AND u.geloescht = 0
                    ORDER BY u.datum ASC, us.beginn ASC, us.ende ASC');
                $stmt->bindParam(':gruppe_id', $gruppe_id);
                $stmt->bindParam(':datum_von', $datum_von);
                $stmt->bindParam(':datum_bis', $datum_bis);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                $stmt_us = $conn->prepare('SELECT * FROM ustunde WHERE id = :ustunde_id');
                $stmt_f = $conn->prepare('SELECT * FROM fach WHERE id = :fach_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['gruppe_id']) {
                        $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                        $stmt_g->execute();
                        $grp = $stmt_g->fetch(PDO::FETCH_ASSOC);
                        $row['gruppe'] = $grp;
                    }
                    
                    if ($row['lehrer_id']) {
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $leh;
                    }
                    
                    if ($row['ustunde_id']) {
                        $stmt_us->bindParam(':ustunde_id', $row['ustunde_id']);
                        $stmt_us->execute();
                        $ustd = $stmt_us->fetch(PDO::FETCH_ASSOC);
                        $row['ustunde'] = $ustd;
                    }
                    
                    if ($row['fach_id']) {
                        $stmt_f->bindParam(':fach_id', $row['fach_id']);
                        $stmt_f->execute();
                        $fach = $stmt_f->fetch(PDO::FETCH_ASSOC);
                        $row['fach'] = $fach;
                    }
                    
                    array_push($result, $row);
                }

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
                
            return json_encode($result);;
        }

        // spezielle Abfragen fuer das Klassenbuch
        // Abfrage eine Gruppe ueber eine Woche mit zus. Gruppen der Teilnehmer
        public static function read_by_gruppe_von_bis_plus($gruppe_id, $datum_von, $datum_bis) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT u.* FROM unterricht u 
                    LEFT OUTER JOIN ustunde us ON (us.id = u.ustunde_id)
                    WHERE u.gruppe_id IN (
	                    SELECT DISTINCT g2.id
                        FROM gruppe g1
                        LEFT OUTER JOIN belegung b1 on (b1.gruppe_id = g1.id)
                        LEFT OUTER JOIN belegung b2 ON (b2.schueler_id = b1.schueler_id)
                        LEFT OUTER JOIN gruppe g2 on (g2.id = b2.gruppe_id)
                        WHERE g1.id = :gruppe_id)
                    AND u.datum BETWEEN :datum_von AND :datum_bis 
                    AND u.geloescht = 0
                    ORDER BY u.datum ASC, us.beginn ASC, us.ende ASC');
                $stmt->bindParam(':gruppe_id', $gruppe_id);
                $stmt->bindParam(':datum_von', $datum_von);
                $stmt->bindParam(':datum_bis', $datum_bis);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                $stmt_us = $conn->prepare('SELECT * FROM ustunde WHERE id = :ustunde_id');
                $stmt_f = $conn->prepare('SELECT * FROM fach WHERE id = :fach_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['gruppe_id']) {
                        $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                        $stmt_g->execute();
                        $grp = $stmt_g->fetch(PDO::FETCH_ASSOC);
                        $row['gruppe'] = $grp;
                    }
                    
                    if ($row['lehrer_id']) {
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $leh;
                    }
                    
                    if ($row['ustunde_id']) {
                        $stmt_us->bindParam(':ustunde_id', $row['ustunde_id']);
                        $stmt_us->execute();
                        $ustd = $stmt_us->fetch(PDO::FETCH_ASSOC);
                        $row['ustunde'] = $ustd;
                    }
                    
                    if ($row['fach_id']) {
                        $stmt_f->bindParam(':fach_id', $row['fach_id']);
                        $stmt_f->execute();
                        $fach = $stmt_f->fetch(PDO::FETCH_ASSOC);
                        $row['fach'] = $fach;
                    }
                    
                    array_push($result, $row);
                }

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
                
            return json_encode($result);;
        }

        // Abfrage eines Lehrers ueber eine Woche 
        public static function read_by_lehrer_von_bis($lehrer_id, $datum_von, $datum_bis) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT u.* FROM unterricht u 
                    LEFT OUTER JOIN ustunde us ON (us.id = u.ustunde_id)
                    WHERE u.lehrer_id = :lehrer_id 
                    AND u.datum BETWEEN :datum_von AND :datum_bis 
                    AND u.geloescht = 0
                    ORDER BY u.datum ASC, us.beginn ASC, us.ende ASC');
                $stmt->bindParam(':lehrer_id', $lehrer_id);
                $stmt->bindParam(':datum_von', $datum_von);
                $stmt->bindParam(':datum_bis', $datum_bis);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                $stmt_us = $conn->prepare('SELECT * FROM ustunde WHERE id = :ustunde_id');
                $stmt_f = $conn->prepare('SELECT * FROM fach WHERE id = :fach_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['gruppe_id']) {
                        $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                        $stmt_g->execute();
                        $grp = $stmt_g->fetch(PDO::FETCH_ASSOC);
                        $row['gruppe'] = $grp;
                    }
                    
                    if ($row['lehrer_id']) {
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $leh = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $leh;
                    }
                    
                    if ($row['ustunde_id']) {
                        $stmt_us->bindParam(':ustunde_id', $row['ustunde_id']);
                        $stmt_us->execute();
                        $ustd = $stmt_us->fetch(PDO::FETCH_ASSOC);
                        $row['ustunde'] = $ustd;
                    }
                    
                    if ($row['fach_id']) {
                        $stmt_f->bindParam(':fach_id', $row['fach_id']);
                        $stmt_f->execute();
                        $fach = $stmt_f->fetch(PDO::FETCH_ASSOC);
                        $row['fach'] = $fach;
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
