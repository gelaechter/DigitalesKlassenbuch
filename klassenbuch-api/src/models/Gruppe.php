<?php
    class Gruppe {
        public static function read_single($id) {
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
                $stmt = $conn->prepare('SELECT * FROM belegung WHERE gruppe_id = :gruppe_id');
                $stmt->bindParam(':gruppe_id', $id);
                $stmt->execute();
                $belegungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

                /*
                 * Unterrichte nur ueber Abfrage mit Zeitraum
                 * 
                $stmt = $conn->prepare('SELECT * FROM unterricht WHERE gruppe_id = :gruppe_id');
                $stmt->bindParam(':gruppe_id', $id);
                $stmt->execute();
                $beleg = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['unterricht'] = $beleg;
                 */

                // Schueler, die diese Lerngruppe als Klasse/Tutoriat haben
                $stmt = $conn->prepare('SELECT * FROM schueler WHERE gruppe_id = :gruppe_id');
                $stmt->bindParam(':gruppe_id', $id);
                $stmt->execute();
                $schueler = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['schueler'] = $schueler;

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
                $stmt = $conn->prepare('SELECT * FROM gruppe WHERE geloescht = 0');
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
    }
?>