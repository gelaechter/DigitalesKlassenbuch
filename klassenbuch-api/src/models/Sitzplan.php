<?php
    class Sitzplan {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM sitzplan WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);


                // one-to-one

                // many-to-one
                if ($result['raum_id']) {
                    $stmt = $conn->prepare('SELECT * FROM raum WHERE id = :raum_id');
                    $stmt->bindParam(':raum_id', $result['raum_id']);
                    $stmt->execute();
                    $raum = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['raum'] = $raum;
                }

                if ($result['lehrer_id']) {
                    $stmt = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');
                    $stmt->bindParam(':lehrer_id', $result['lehrer_id']);
                    $stmt->execute();
                    $lehrer = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['lehrer'] = $lehrer;
                }

                // one-to-many
                
                // Die Sitzplätze des Sitzplans
                $stmt = $conn->prepare('SELECT * FROM sitzplatz WHERE sitzplan_id = :sitzplan_id');
                $stmt->bindParam(':sitzplan_id', $id);
                $stmt->execute();
                $belegungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Schuelerdaten zu den Plätzen hinzulesen
                $sitzplatz = array();
                $stmt_s = $conn->prepare('SELECT * FROM schueler WHERE id = :schueler_id');
                foreach ($belegungen as $row) {
                    if ($row['schueler_id']) {
                        $stmt_s->bindParam(':schueler_id', $row['schueler_id']);
                        $stmt_s->execute();
                        $sch = $stmt_s->fetch(PDO::FETCH_ASSOC);
                        $row['schueler'] = $sch;
                    }
                    array_push($sitzplatz, $row);
                }

                $result['sitzplatz'] = $sitzplatz;

                
                // Ermitteln, wie vielen Unterrichten der Sitzplan zugewiesen wurde
                $stmt = $conn->prepare('SELECT COUNT(id) AS usages FROM unterricht WHERE sitzplan_id = :sitzplan_id');
                $stmt->bindParam(':sitzplan_id', $id);
                $stmt->execute();
                $zuweisungen = $stmt->fetch(PDO::FETCH_ASSOC);

                $result['verwendungen'] = $zuweisungen['usages'];


                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }


        public static function read_by_group($gruppe_id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM sitzplan WHERE gruppe_id = :gruppe_id ORDER BY created_at DESC');
                $stmt->bindParam(':gruppe_id', $gruppe_id);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_r = $conn->prepare('SELECT * FROM raum WHERE id = :raum_id');
                $stmt_l = $conn->prepare('SELECT * FROM lehrer WHERE id = :lehrer_id');

                foreach ($data as $row) {

                    // many-to-one
                    if ($row['raum_id']) {
                        $stmt_r->bindParam(':raum_id', $row['raum_id']);
                        $stmt_r->execute();
                        $raum = $stmt_r->fetch(PDO::FETCH_ASSOC);
                        $row['raum'] = $raum;
                    }

                    if ($row['lehrer_id']) {                        
                        $stmt_l->bindParam(':lehrer_id', $row['lehrer_id']);
                        $stmt_l->execute();
                        $lehrer = $stmt_l->fetch(PDO::FETCH_ASSOC);
                        $row['lehrer'] = $lehrer;
                    }

                    array_push($result, $row);
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
                $stmt = $conn->prepare('SELECT * FROM sitzplan');
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_r = $conn->prepare('SELECT * FROM raum WHERE id = :raum_id');

                foreach ($data as $row) {

                    // many-to-one
                    if ($row['raum_id']) {
                        $stmt_r->bindParam(':raum_id', $row['raum_id']);
                        $stmt_r->execute();
                        $raum = $stmt_r->fetch(PDO::FETCH_ASSOC);
                        $row['raum'] = $raum;
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