<?php

class DB {    
    private $dbuser = ''; 
    private $dbpass = ''; 
    private $connect_string = 'mysql:host=;dbname=;charset=utf8';
   
    public function connect() {
        $connection = new PDO($this->connect_string, $this->dbuser, $this->dbpass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }

    public static function create_insert_query($table, $json) {
        $query = 'INSERT INTO ' . $table . ' ';
        $field_list = '';
        $value_list = '';

        // Felder in json suchen, uuid und created_at, updated_at ignorieren
        $delim = '(';
        foreach ($json as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $field_list .= $delim;
                $field_list .= $key;
                $value_list .= $delim;
                $value_list .= ':';
                $value_list .= $key;
                $delim = ', ';
            }
        }
        // created_at und created_by ergänzen
        $field_list .= $delim;
        $field_list .= 'created_at';
        $value_list .= $delim;
        $value_list .= "'" . date("Y-m-d H:i:s") ."'";

        $field_list .= $delim;
        $field_list .= 'created_by';
        $value_list .= $delim;
        $value_list .= "'" . $_SESSION['user_iserv'] . "'";

        // Teile zusammensetzen
        $query .= $field_list;
        $query .= ') VALUES ';
        $query .= $value_list;
        $query .= ')';

        return $query;
    }

    public static function create_update_query($table, $json) {
        $query = 'UPDATE ' . $table . ' SET ';
        $field_list = '';

        // Felder in json suchen, uuid und created_at, updated_at ignorieren
        $delim = '';
        foreach ($json as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $field_list .= $delim;
                $field_list .= $key;
                $field_list .= ' = ';
                $field_list .= ':';
                $field_list .= $key;
                $delim = ', ';
            }
        }
        // updated_at und updated_by ergänzen
        $field_list .= $delim;
        $field_list .= "updated_at = '" . date("Y-m-d H:i:s") . "'";
        $field_list .= $delim;
        $field_list .= "updated_by = '" . $_SESSION['user_iserv'] . "'";
        
        // UPDATE-TIMESTAMP wird durch die Datenbank geaendert
        // $field_list .= $delim;
        // $field_list .= 'updated_at = CURRENT_TIMESTAMP';

        $query .= $field_list;
        $query .= ' WHERE id = :id';

        return $query;
    }

}

// Zulässigkeitsprüfung & Zugriffszählung
// a) Feld "upload_allowed" muss in Tabelle update gesetzt sein
// b) Die Anzahl der bereits gezählten Zugriffe (pro Tag) in access_count muss kleiner als access_limit sein.
// Bei Zulässigkeit ist der Zugriffszähler access_count zu erhöhen.

try {
    $db = new DB();
    $conn = $db->connect();
    $stmt = $conn->prepare('SELECT upload_allowed, access_count, access_limit, access_last FROM `update` LIMIT 1');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;
} catch (PDOException $ex) {
    header('HTTP/1.0 500 Internal Server Error');
    die('{"error": {"message": "'.$ex->getMessage().'"}}');    
}

if($result['upload_allowed']==0){
    header('HTTP/1.0 403 Forbidden');
    die("Upload not allowed.");
}

if($result['access_count']>=$result['access_limit']){
    header('HTTP/1.0 403 Forbidden');
    die("Quota exceeded.");
}

//Zugriff zählen
//Zugriffszähler bei neuem Tag zurücksetzen
$heute = date("Y-m-d");
if($result['access_last'] == null || substr($result['access_last'],0,10) < $heute){
    $access_count = 0;
} else {
    $access_count = $result['access_count']+1;
}

try {
    $db = new DB();
    $conn = $db->connect();
    $stmt = $conn->prepare('UPDATE `update` SET access_count = :access_count, access_last = :jetzt');
    $stmt->bindParam(':access_count', $access_count);
    $stmt->bindParam(':jetzt', date('Y-m-d H:i:s'));
    $stmt->execute();
    
    $conn = null;
} catch (PDOException $ex) {
    header('HTTP/1.0 500 Internal Server Error');
    die('{"error": {"138 message": "'.$ex->getMessage().'"}}');    
}




//Prüfung der POST-Daten
//a) Vorandensein von Daten
//b) Arrays "gruppen, schueler, belegungen, lehrer" Maximalgroesse 10.000 Einträge

$rawInputData =  file_get_contents('php://input');

//DEBUG
// $rawInputData = '{"gruppen" : [{"name":"wn301"},{"name":"ph99"}]}';

if($rawInputData==null){
    header('HTTP/1.0 400 Bad Request');
    die("Missing Data.");
}


//JSON-Daten aus POST lesen
$assoc = json_decode($rawInputData, true);
$ziel = $assoc['ziel'];
try {
    if ($ziel == 'gruppen') {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('TRUNCATE `update_gruppe`;');
        $stmt->execute();

        $count = 0;
        $stmt = $conn->prepare('INSERT INTO `update_gruppe` (`danis_gruppe_id`, `apollon_gruppe_id`, `name`, `lehrer_kuerzel`) VALUES (:danis_gruppe_id, :apollon_gruppe_id, :name, :lehrer_kuerzel);');
        foreach($assoc['data'] as $row) {
            $stmt->bindParam(':danis_gruppe_id', $row["danis_gruppe_id"]);
            $stmt->bindParam(':apollon_gruppe_id', $row["apollon_gruppe_id"]);
            $stmt->bindParam(':name', $row["name"]);
            $stmt->bindParam(':lehrer_kuerzel', $row["lehrer_kuerzel"]);
            $stmt->execute();
            $count++;
        }
            
        $conn = null;
        echo("Gruppen-Daten hochgeladen, ".$count." Datensätze gespeichert.");
    }
    if ($ziel == 'belegungen') {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('TRUNCATE `update_belegung`;');
        $stmt->execute();

        $stmt = $conn->prepare('INSERT INTO `update_belegung`(`danis_schueler_id`, `apollon_schueler_id`, `danis_gruppe_id`, `apollon_gruppe_id`, `von_hj`, `bis_hj`, `von`, `bis`) VALUES (:danis_schueler_id, :apollon_schueler_id, :danis_gruppe_id, :apollon_gruppe_id, :von_hj, :bis_hj, :von, :bis);');
        $count = 0;
        foreach($assoc['data'] as $row) {
            $stmt->bindParam(':danis_schueler_id', $row["danis_schueler_id"]);
            $stmt->bindParam(':apollon_schueler_id', $row["apollon_schueler_id"]);
            $stmt->bindParam(':danis_gruppe_id', $row["danis_gruppe_id"]);
            $stmt->bindParam(':apollon_gruppe_id', $row["apollon_gruppe_id"]);
            $stmt->bindParam(':von_hj', $row["von_hj"]);
            $stmt->bindParam(':bis_hj', $row["bis_hj"]);
            $stmt->bindParam(':von', $row["von"]);
            $stmt->bindParam(':bis', $row["bis"]);
            $stmt->execute();
            $count++;
        }
            
        $conn = null;
        echo("Belegungs-Daten hochgeladen, ".$count." Datensätze gespeichert.");
    }
    if ($ziel == 'schueler') {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('TRUNCATE `update_schueler`;');
        $stmt->execute();

        $stmt = $conn->prepare('INSERT INTO `update_schueler`(`danis_schueler_id`, `apollon_schueler_id`, `vorname`, `nachname`, `iserv`, `danis_gruppe_id`, `apollon_gruppe_id`) VALUES (:danis_schueler_id, :apollon_schueler_id, :vorname, :nachname, :iserv, :danis_gruppe_id, :apollon_gruppe_id);');
        $count = 0;
        foreach($assoc['data'] as $row) {
            $stmt->bindParam(':danis_schueler_id', $row["danis_schueler_id"]);
            $stmt->bindParam(':apollon_schueler_id', $row["apollon_schueler_id"]);
            $stmt->bindParam(':vorname', $row["vorname"]);
            $stmt->bindParam(':nachname', $row["nachname"]);
            $stmt->bindParam(':iserv', $row["iserv"]);
            $stmt->bindParam(':danis_gruppe_id', $row["danis_gruppe_id"]);
            $stmt->bindParam(':apollon_gruppe_id', $row["apollon_gruppe_id"]);
            $stmt->execute();
            $count++;
        }
            
        $conn = null;
        echo("Schueler-Daten hochgeladen, ".$count." Datensätze gespeichert.");
    }
    if ($ziel == 'lehrer') {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('TRUNCATE `update_lehrer`;');
        $stmt->execute();

        $stmt = $conn->prepare('INSERT INTO `update_lehrer`(`vorname`, `nachname`, `kuerzel`) VALUES (:vorname, :nachname, :kuerzel);');
        $count = 0;
        foreach($assoc['data'] as $row) {
            $stmt->bindParam(':vorname', $row["vorname"]);
            $stmt->bindParam(':nachname', $row["nachname"]);
            $stmt->bindParam(':kuerzel', $row["kuerzel"]);
            $stmt->execute();
            $count++;
        }
            
        $conn = null;
        echo("Lehrer-Daten hochgeladen, ".$count." Datensätze gespeichert.");
    }
} catch (PDOException $ex) {
    header('HTTP/1.0 500 Internal Server Error' . $ex->getMessage());
    die('{"error": {"138 message": "'.$ex->getMessage().'"}}');    
}

?>