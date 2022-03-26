<?php
    class Mitteilung {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM mitteilung WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);                

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
                $stmt = $conn->prepare('SELECT * FROM mitteilung WHERE geloescht = 0');
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }
    }
?>