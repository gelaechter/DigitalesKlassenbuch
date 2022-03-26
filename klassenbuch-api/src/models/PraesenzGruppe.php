<?php
    class PraesenzGruppe {
        public static function read_by_gruppe($gruppe_id) {
            try {
                
                $sql = '
                select 
                NULL AS id, NULL AS unterricht_id, 
                b.id AS belegung_id, 
                NULL AS fehlt, NULL AS entschuldigt, NULL AS verspaetet, 
                NULL AS bemerkung,
                b.schueler_id AS schueler_id, b.gruppe_id AS gruppe_id,
                b.beginn AS beginn, b.ende AS ende,
                s.nachname AS nachname, s.vorname AS vorname, 
                s.teilgruppe AS teilgruppe,s.gruppe_id AS s_gruppe_id 
                from 
                (
                    (
                        gruppe g
                        left join belegung b on
                            (
                                (b.gruppe_id = g.id)
                                AND
                                b.beginn <= :heute
                                AND
                                b.ende >= :heute
                            )
                    ) 
                    left join schueler s on
                        (
                            (s.id = b.schueler_id)
                        )
                )
                WHERE 
                b.gruppe_id = :gruppe_id 
                ORDER BY nachname, vorname
                ;
                ';

                $db = new DB();
                $conn = $db->connect();
                
                //altes Statement bis 19.12.2021
                //$stmt = $conn->prepare('SELECT * FROM praesenz_gruppe WHERE gruppe_id = :gruppe_id ORDER BY nachname, vorname');               
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':gruppe_id', $gruppe_id);

                //neu hinzugefügt zur Filterung der Belegungen gegen das aktuelle Datum
                $heute = date("Y-m-d");
                $stmt->bindParam(':heute', $heute);


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
