<?php
    class Belegung {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM belegung WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one
                if ($result['schueler_id']) {
                    $stmt = $conn->prepare('SELECT * FROM schueler WHERE id = :schueler_id');
                    $stmt->bindParam(':schueler_id', $result['schueler_id']);
                    $stmt->execute();
                    $sch = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['schueler'] = $sch;
                }

                if ($result['gruppe_id']) {
                    $stmt = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');
                    $stmt->bindParam(':gruppe_id', $result['gruppe_id']);
                    $stmt->execute();
                    $grp = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['gruppe'] = $grp;
                }

                // many-to-one

                // one-to-many
                $stmt = $conn->prepare('SELECT * FROM praesenz WHERE belegung_id = :belegung_id');
                $stmt->bindParam(':belegung_id', $id);
                $stmt->execute();
                $prae = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['praesenz'] = $prae;

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
                $stmt = $conn->prepare('SELECT * FROM belegung');
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_s = $conn->prepare('SELECT * FROM schueler WHERE id = :schueler_id');
                $stmt_g = $conn->prepare('SELECT * FROM gruppe WHERE id = :gruppe_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['schueler_id']) {
                        $stmt_s->bindParam(':schueler_id', $row['schueler_id']);
                        $stmt_s->execute();
                        $sch = $stmt_s->fetch(PDO::FETCH_ASSOC);
                        $row['schueler'] = $sch;
                    }
                    
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