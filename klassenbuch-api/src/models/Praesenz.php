<?php
    class Praesenz {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM praesenz WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one
                $stmt = $conn->prepare('SELECT * FROM unterricht WHERE id = :unterricht_id');
                $stmt->bindParam(':unterricht_id', $id);
                $stmt->execute();
                $unt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['unterricht'] = $unt;

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
                $stmt = $conn->prepare('SELECT * FROM unterricht');
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();
                $stmt_u = $conn->prepare('SELECT * FROM unterricht WHERE id = :unterricht_id');
                $stmt_b = $conn->prepare('SELECT * FROM belegung WHERE id = :belegung_id');
                $stmt_s = $conn->prepare('SELECT * from schueler WHERE id = :schueler_id');
                $stmt_g = $conn->prepare('SELECT * from gruppe WHERE id = :gruppe_id');

                foreach ($data as $row) {
                    // one-to-one, many-to-one
                    if ($row['unterricht_id']) {
                        $stmt_u->bindParam(':unterricht_id', $row['unterricht_id']);
                        $stmt_u->execute();
                        $unt = $stmt_u->fetch(PDO::FETCH_ASSOC);
                        $row['unterricht'] = $unt;
                    }
                    
                    if ($row['belegung_id']) {
                        $stmt_b->bindParam(':belegung_id', $row['belegung_id']);
                        $stmt_b->execute();
                        $bel = $stmt_b->fetch(PDO::FETCH_ASSOC);
                        if ($bel['schueler_id']) {
                            $stmt_s->bindParam(':schueler_id', $row['schueler_id']);
                            $stmt_s->execute();
                            $sch = $stmt_s->fetch(PDO::FETCH_ASSOC);
                            $bel['schueler'] = $sch;
                        }
                        if ($bel['gruppe_id']) {
                            $stmt_g->bindParam(':gruppe_id', $row['gruppe_id']);
                            $stmt_g->execute();
                            $gru = $stmt_g->fetch(PDO::FETCH_ASSOC);
                            $bel['gruppe'] = $gru;
                        }
                        $row['belegung'] = $bel;
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
