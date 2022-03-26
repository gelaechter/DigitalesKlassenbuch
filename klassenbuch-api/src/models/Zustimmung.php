<?php
    class Zustimmung {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM zustimmung WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one
                $result['erledigung'] = json_decode(Erledigung::read_single($result['erledigung_id']), true);

                // many-to-one

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
                $stmt = $conn->prepare('SELECT * FROM zustimmung WHERE geloescht = 0');
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


        public static function read_by_lehrer($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT z.*
                                        FROM zustimmung z
                                        INNER JOIN erledigung er ON er.id = z.erledigung_id
                                        WHERE z.lehrer_id = :id
                                        AND z.zustimmung = 0
                                        AND z.geloescht = 0
                                        AND er.geloescht = 0
                                        AND er.lehrer_id IS NULL
                                        ');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result_z = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // one-to-one               

                // many-to-one

                // one-to-many                            
                $result = array();
                foreach($result_z as $row){                    
                    $row['erledigung'] = json_decode(Erledigung::read_single($row['erledigung_id']), true);
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