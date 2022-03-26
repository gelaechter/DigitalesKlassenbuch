<?php
    class Lehrer {
        public static function read_single($id) {
            try {
                $db = new DB();
                $conn = $db->connect();
                $stmt = $conn->prepare('SELECT * FROM lehrer WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // one-to-one

                // many-to-one

                // one-to-many
                $stmt = $conn->prepare('SELECT * FROM gruppe WHERE lehrer_id = :lehrer_id');
                $stmt->bindParam(':lehrer_id', $id);
                $stmt->execute();
                $grp = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['gruppe'] = $grp;

                $stmt = $conn->prepare('SELECT * FROM unterricht WHERE lehrer_id = :lehrer_id');
                $stmt->bindParam(':lehrer_id', $id);
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
                $stmt = $conn->prepare('SELECT * FROM lehrer');
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
    }
?>