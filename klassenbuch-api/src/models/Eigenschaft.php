<?php
    class Eigenschaft {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM eigenschaft WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one

                // one-to-many (-> betroffene Schüler und zugehörige Erledigungen)

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
                $stmt = $conn->prepare('SELECT ei.* , IFNULL(lc.kuerzel, "(JAG)") as created_by_kuerzel
                                        FROM eigenschaft ei
                                        LEFT JOIN lehrer lc ON lc.id = lehrer_id
                                        WHERE (privat = 0 OR lehrer_id = :user_lehrer_id)
                                        ');
                
                $stmt->bindParam(':user_lehrer_id', $_SESSION['user_lehrer_id']);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();

                foreach ($data as $row) {
                    // one-to-one, many-to-one

                    array_push($result, $row);
                }

              

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }

        public static function read_by_group($id_g) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT DISTINCT ei.* , IFNULL(lc.kuerzel, "(JAG)") as created_by_kuerzel
                                        FROM belegung b
                                        LEFT JOIN erledigung er ON (er.schueler_id = b.schueler_id AND er.geloescht = 0)
                                        LEFT JOIN eigenschaft ei ON (ei.id = er.eigenschaft_id AND ei.geloescht = 0)
                                        LEFT JOIN lehrer lc ON lc.id = ei.lehrer_id
                                        WHERE 
                                        (ei.privat = 0 OR ei.lehrer_id = :user_lehrer_id)
                                        AND b.gruppe_id = :id_g
                                        AND b.beginn <= :heute
                                        AND b.ende >= :heute
                                        ');
                
                $stmt->bindParam(':user_lehrer_id', $_SESSION['user_lehrer_id']);
                $stmt->bindParam(':id_g', $id_g);
                $heute = date("Y-m-d");
                $stmt->bindParam(':heute', $heute);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = array();

                foreach ($data as $row) {
                    // one-to-one, many-to-one

                    array_push($result, $row);
                }

              

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);
        }


    }
?>