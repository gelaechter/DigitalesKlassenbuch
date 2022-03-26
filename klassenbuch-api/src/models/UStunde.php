<?php
    class UStunde {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM ustunde WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one

                // one-to-many
                $stmt = $conn->prepare('SELECT * FROM unterricht WHERE ustunde_id = :ustunde_id');
                $stmt->bindParam(':ustunde_id', $id);
                $stmt->execute();
                $unt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['unterricht'] = $unt;

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
                $stmt = $conn->prepare('SELECT * FROM ustunde');
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
        
            return json_encode($result);;
        }

        public static function read_anzeigen() {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM ustunde WHERE anzeige > 0 ORDER BY block ASC');
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
        
            return json_encode($result);;
        }
    


        public static function read_single_by_beginn($time) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT *
                                        FROM ustunde
                                        WHERE beginn >= :beginn
                                        ORDER BY beginn ASC LIMIT 1');
                $stmt->bindParam(':beginn', $time);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
               

                // one-to-one

                // many-to-one

                // one-to-many
                
                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }



        public static function read_single_by_ende($time) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT *
                                        FROM ustunde      
                                        WHERE ende >= :ende                                  
                                        ORDER BY ende ASC LIMIT 1');
                $stmt->bindParam(':ende', $time);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
               

                // one-to-one

                // many-to-one

                // one-to-many
                
                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }


    }
?>