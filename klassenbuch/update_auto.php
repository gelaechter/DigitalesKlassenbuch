<?php


//Prüfung der POST-Daten
//a) Vorandensein von Daten
$rawInputData =  file_get_contents('php://input');
if($rawInputData==null){
    header('HTTP/1.0 400 Bad Request');
    die("Missing Data.");
}

//JSON-Daten aus POST lesen
//Prüfen auf Ziel "update" und "pass" passwort
$assoc = json_decode($rawInputData, true);
$ziel = $assoc['ziel'];
$pass = $assoc['pass'];
if($ziel!="update" || $pass != "passwort"){
    header('HTTP/1.0 400 Bad Request');
    die("Missing Data.");
}



//Übersetzung der Belegungsdauerangaben in Halbjahresform in Daten YYYY-MM-DD
$hj_beginn = array("2021-09-02", "2022-02-02","2022-08-25","2023-02-01");
$hj_ende = array("2022-01-30", "2022-07-13","2023-01-29","2023-07-05");

$report = new Report();
$report->add("Update Klassenbuch gestartet. ".date("Y-m-d H:i:s"));

check_zugriff();





//Problem:
//Schüler 2x im Update Satz (Danis + Apollon, bei Jg. 11-13);
//Danis-Datensatz ohne Apollon-ID.
//Wenn bestehende Datenbank dann ohne Danis-ID => ungewollte Neuanlage
//Abhilfe: zunächst "Update" oder Zusammenfassen der Daten in update_schueler
$report->add("Starte Vorbereinigung Update-Datensätze");
clean_update();


$report->add("Starte Lehrer Insert/Update");
lehrer_insert();

$report->add("Starte Gruppen Insert/Update");
gruppe_insert();


$report->add("Starte Schueler Insert/Update");
schueler_insert();


$report->add("Starte Belegung Insert/Update");
belegung_insert();


$report->add("Update Klassenbuch beendet.");

echo($report->getText());



class Report{
    private $text ="";

    public function add($txt){
        $this->text .= '<br>'."\n".date('Y-m-d H:i:s'). ' : '.$txt;
    }

    public function getText(){
        return $this->text;
    }
}


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
        $field_list .= "updated_by = 'update_auto.php'";
        
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
function check_zugriff(){
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

    echo('Access allowed.');
}


//Beseitigt alle Oberstufen-SuS und deren Belegungen, die nicht Fremd-SuS sind (Nachname = "ZZ ...") und
// die keine eingetragene Danis-ID haben
function clean_update(){
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT s.*, b.id as belegung_id, b.apollon_gruppe_id, b.danis_gruppe_id
                                FROM update_schueler s
                                LEFT JOIN update_belegung b ON b.apollon_schueler_id = s.apollon_schueler_id
                                WHERE 
                                s.danis_schueler_id IS NULL 
                                AND s.nachname NOT LIKE "ZZ %"');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt_del_s = $conn->prepare("DELETE FROM update_schueler WHERE id = :s_id");
        $stmt_del_b = $conn->prepare("DELETE FROM update_belegung WHERE id = :b_id");


        foreach($result as $schueler){      
       
            //echo ("<br>SKIPPING (missing Danis-ID) ".$schueler['vorname']." ".$schueler['nachname']." Belegung #".$schueler['belegung_id']);
            $GLOBALS['report']->add("[WARN] fehlende Danis-ID bei Schüler ".$schueler['vorname']." ".$schueler['nachname']);
            
            $stmt_del_s->bindParam(':s_id', $schueler['id']);
            $stmt_del_b->bindParam(':b_id', $schueler['belegung_id']);

            $stmt_del_b->execute();
            $stmt_del_s->execute();
        
        }

        
        $conn = null;
    
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error');
        die('{"error": {"138 message": "'.$ex->getMessage().'"}}');    
    }

    
}


function lehrer_insert(){
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT * FROM update_lehrer");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt_ins = $conn->prepare("INSERT INTO lehrer (nachname, vorname, kuerzel) VALUES (:vorname, :nachname, :kuerzel)");
        $stmt_upd_id = $conn->prepare("UPDATE update_lehrer SET lehrer_id =:lehrer_id WHERE id = :id");
        $stmt_upd_lehrer = $conn->prepare("UPDATE lehrer SET vorname = :vorname, nachname = :nachname, updated_by='update_auto.php' WHERE id = :id");
        $stmt_lastid = $conn->prepare("SELECT LAST_INSERT_ID() as last_id");

        foreach($result as $lehrer){
            $klabu_lehrer = get_klabu_lehrer($lehrer);
    
            if(!$klabu_lehrer){
                $GLOBALS['report']->add("[INFO] Insert Lehrer ".$lehrer['nachname']." ".$lehrer['kuerzel']);
               
                $stmt_ins->bindParam(':vorname',$lehrer['vorname']);
                $stmt_ins->bindParam(':nachname',$lehrer['nachname']);
                $stmt_ins->bindParam(':kuerzel',$lehrer['kuerzel']);

                $stmt_ins->execute();

                $stmt_lastid->execute();
                $lastid_res = $stmt_lastid->fetch(PDO::FETCH_ASSOC);
                $klabu_id = $lastid_res['last_id'];
                
                $stmt_upd_id->bindParam(':lehrer_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$lehrer['id']);
                $stmt_upd_id->execute();
                
            } else {

                $klabu_id = $klabu_lehrer['id'];
                $stmt_upd_id->bindParam(':lehrer_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$lehrer['id']);
                $stmt_upd_id->execute();

                $update_id = $klabu_lehrer['update_id'];
                if( isset($update_id) &&
                    ($lehrer['vorname'] != $klabu_lehrer['vorname'] 
                    || $lehrer['nachname'] != $klabu_lehrer['nachname'])
                   ){

                    $GLOBALS['report']->add("[WARN] Widerspruechliche Daten zu Lehrer ".$lehrer['kuerzel'].": (".$lehrer['vorname']." ".$lehrer['nachname']."), behalte: (".$klabu_lehrer['vorname']." ".$klabu_lehrer['nachname'].")");          
                } else {
                  if($lehrer['vorname'] != $klabu_lehrer['vorname'] 
                    || $lehrer['nachname'] != $klabu_lehrer['nachname']
                    ){

                        $GLOBALS['report']->add("[INFO] Update ".$lehrer['kuerzel'].": (".$klabu_lehrer['vorname']." ".$klabu_lehrer['nachname'].") --> (".$lehrer['vorname']." ".$lehrer['nachname'].")");      
                        
                        $stmt_upd_lehrer->bindParam(':vorname',$lehrer['vorname']);
                        $stmt_upd_lehrer->bindParam(':nachname',$lehrer['nachname']);
                        $stmt_upd_lehrer->bindParam(':id',$klabu_id);

                        $stmt_upd_lehrer->execute();

                    }
                }



            }
        }
        
        $conn = null;

    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error');
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }

}




function gruppe_insert(){
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT * FROM update_gruppe");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt_ins = $conn->prepare("INSERT INTO gruppe (name, danis_id, apollon_id, lehrer_id) VALUES (:name, :danis_id, :apollon_id, :lehrer_id)");
        $stmt_upd_gruppe = $conn->prepare("UPDATE gruppe SET name = :name, lehrer_id = :lehrer_id, updated_by='update_auto.php' WHERE id = :id");
        
        $stmt_upd_id = $conn->prepare("UPDATE update_gruppe SET gruppe_id =:gruppe_id WHERE id = :id");
        $stmt_lastid = $conn->prepare("SELECT LAST_INSERT_ID() as last_id");

        
        foreach($result as $gruppe){
            $klabu_gruppe = get_klabu_gruppe($gruppe);
            
            $lehrer_id = null;
            $lehrer = get_klabu_lehrer($gruppe);
            if($lehrer){
                $lehrer_id = $lehrer['id'];
            }

            if(!$klabu_gruppe){

                $GLOBALS['report']->add("[INFO] Insert Gruppe ".$gruppe['name']);
                
                //$stmt_ins->bindParam(':',$lehrer['']);
                $stmt_ins->bindParam(':name',$gruppe['name']);
                $stmt_ins->bindParam(':apollon_id',$gruppe['apollon_gruppe_id']);
                $stmt_ins->bindParam(':danis_id',$gruppe['danis_gruppe_id']);
                $stmt_ins->bindParam(':lehrer_id',$lehrer_id);
                
                $stmt_ins->execute();

                $stmt_lastid->execute();
                $lastid_res = $stmt_lastid->fetch(PDO::FETCH_ASSOC);
                $klabu_id = $lastid_res['last_id'];
                
                $stmt_upd_id->bindParam(':gruppe_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$gruppe['id']);
                $stmt_upd_id->execute();

            } else {

                $klabu_id = $klabu_gruppe['id'];
                $stmt_upd_id->bindParam(':gruppe_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$gruppe['id']);
                $stmt_upd_id->execute();

                $update_id = $klabu_gruppe['update_id'];

                //Update von Namen und Lehrer der gefundenen Gruppe prüfen und ggf. vornehmen
                //Update nicht ausführen, wenn Gruppe bereits einem anderem Update-Datensatz zugeordnet ist
                $klabu_id = $klabu_gruppe['id'];
                $klabu_name =  $klabu_gruppe['name'];
                $klabu_lehrer_id = $klabu_gruppe['lehrer_id'];
                $klabu_lehrer_kuerzel =$klabu_gruppe['lehrer_kuerzel'];

                if( !isset($update_id) &&
                    ($klabu_name != $gruppe['name']
                    || $klabu_lehrer_id != $lehrer_id) ){
                        $GLOBALS['report']->add("[INFO] Update Gruppe (".$klabu_lehrer_kuerzel.": ".$klabu_name.") -> (".$lehrer['kuerzel'].": ".$gruppe['name'].")");
                
                        $stmt_upd_gruppe->bindParam(':id', $klabu_id);
                        $stmt_upd_gruppe->bindParam(':name', $gruppe['name']);
                        $stmt_upd_gruppe->bindParam(':lehrer_id', $lehrer_id);
                        $stmt_upd_gruppe->execute();
                        
                    }

            }
        }

        $conn = null;

    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error');
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }
    
  

}


function schueler_insert(){
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT * FROM update_schueler");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt_ins = $conn->prepare("INSERT INTO schueler (vorname, nachname, iserv, danis_id, apollon_id, gruppe_id) VALUES (:vorname, :nachname, :iserv, :danis_id, :apollon_id, :gruppe_id)");

        $stmt_upd_id = $conn->prepare("UPDATE update_schueler SET schueler_id =:schueler_id WHERE id = :id");
        $stmt_lastid = $conn->prepare("SELECT LAST_INSERT_ID() as last_id");

        foreach($result as $schueler){
            $klabu_schueler = get_klabu_schueler($schueler);
            $gruppe_id = get_klabu_gruppe_id($schueler);
    
            if(!$klabu_schueler){
                $GLOBALS['report']->add("[INFO] Insert Schueler ".$schueler['vorname']);
                
                
                $stmt_ins->bindParam(':vorname',$schueler['vorname']);
                $stmt_ins->bindParam(':nachname',$schueler['nachname']);
                $stmt_ins->bindParam(':iserv',$schueler['iserv']);
                $stmt_ins->bindParam(':danis_id',$schueler['danis_schueler_id']);
                $stmt_ins->bindParam(':apollon_id',$schueler['apollon_schueler_id']);
                $stmt_ins->bindParam(':gruppe_id',$gruppe_id);
    
                $stmt_ins->execute();

                $stmt_lastid->execute();
                $lastid_res = $stmt_lastid->fetch(PDO::FETCH_ASSOC);
                $klabu_id = $lastid_res['last_id'];
                
                $stmt_upd_id->bindParam(':schueler_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$schueler['id']);
                $stmt_upd_id->execute();
    
            } else {

                $klabu_id = $klabu_schueler['id'];
                $stmt_upd_id->bindParam(':schueler_id',$klabu_id);
                $stmt_upd_id->bindParam(':id',$schueler['id']);
                $stmt_upd_id->execute();

                $update_id = $klabu_schueler['update_id'];


                $klabu_id = $klabu_schueler['id'];
                $klabu_nachname =$klabu_schueler['nachname'];
                $klabu_vorname = $klabu_schueler['vorname'];
                $klabu_iserv = $klabu_schueler['iserv'];
                $klabu_gruppe_id = $klabu_schueler['gruppe_id'];
                $klabu_apollon_id = $klabu_schueler['apollon_id'];

                $upd = 0;
                $upd_info = "[INFO] Update Schueler ".$klabu_vorname." ".$klabu_nachname.", klabu_id ".$klabu_id;
                $warn = 0;
                $warn_info = "[WARN] Widerspruechliche Daten: ";
                $upd_array = array();

                if($klabu_vorname != $schueler['vorname']){
                    if(!isset($update_id)){
                        $upd++;
                        $upd_info .= " # [vorname] ".$klabu_vorname." -> ".$schueler['vorname'];
                        $upd_array['vorname'] = $schueler['vorname'];
                    } else {
                        $warn++;
                        $warn_info .= ", behalte [vorname] ".$klabu_vorname." statt ".$schueler['vorname'];
                    }
                }

                if($klabu_nachname != $schueler['nachname']){
                    if(!isset($update_id)){
                        $upd++;
                        $upd_info .= " # [nachname] ".$klabu_nachname." -> ".$schueler['nachname'];
                        $upd_array['nachname'] = $schueler['nachname'];
                    } else {
                        $warn++;
                        $warn_info .= ", behalte [Nachname] ".$klabu_nachname." statt ".$schueler['nachname'];
                    }
                }


                //Update der Stammgruppen-ID nur, wenn der Klassenbuchdatensatz noch nicht
                //einem anderen Datensatz zugeordnet wurde oder noch keine Stammgruppe gesetzt wurde
                if((!isset($update_id) || !isset($klabu_gruppe_id) ) 
                    && isset($gruppe_id) 
                    && $klabu_gruppe_id != $gruppe_id){
                    $upd++;
                    $upd_info .= " # [Stammgruppen-ID] ".$klabu_gruppe_id." -> ".$gruppe_id;
                    $upd_array['gruppe_id'] = $gruppe_id;
                }

                if( (!isset($update_id) || !isset($klabu_iserv))
                    && isset($schueler['iserv']) 
                    && $klabu_iserv != $schueler['iserv']){
                    $upd++;
                    $upd_info .= " # [IServ] ".$klabu_iserv." -> ".$schueler['iserv'];
                    $upd_array['iserv'] = $schueler['iserv'];
                }

                if( (!isset($update_id) || !isset($klabu_apollon_id))
                    && isset($schueler['apollon_schueler_id']) 
                    && $klabu_apollon_id != $schueler['apollon_schueler_id']){
                    $upd++;
                    $upd_info .= " # [Apollon-ID] ".$klabu_apollon_id." -> ".$schueler['apollon_schueler_id'];
                    $upd_array['apollon_id'] = $schueler['apollon_schueler_id'];
                }

                if($upd>0){
                    $GLOBALS['report']->add($upd_info); 
                    
                    $query_upd_schueler = $db->create_update_query("schueler", $upd_array);
                    $stmt_upd_schueler = $conn->prepare($query_upd_schueler);
                    foreach($upd_array as $key => $value){
                        $stmt_upd_schueler->bindParam(':'.$key, $value);
                    }
                    $stmt_upd_schueler->bindParam(':id', $klabu_id);
                    $stmt_upd_schueler->execute();
                     
                }

                if($warn>0){
                    $GLOBALS['report']->add($warn_info);  
                }

            }
            
        }

        $conn = null;

    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error');
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }

}




function belegung_insert(){
   

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT b.*, g.name 
                                FROM update_belegung b 
                                INNER JOIN update_gruppe g ON (
                                    (b.apollon_gruppe_id IS NOT NULL AND g.apollon_gruppe_id = b.apollon_gruppe_id)
                                     OR 
                                    (b.danis_gruppe_id IS NOT NULL AND g.danis_gruppe_id = b.danis_gruppe_id)
                                    )
                                ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $count = 0;
        $count_vergangene =0;

        $stmt_ins = $conn->prepare("INSERT IGNORE INTO belegung (schueler_id, gruppe_id, beginn, ende, created_by) VALUES (:schueler_id, :gruppe_id, :beginn, :ende, 'update_auto.php')");
        $stmt_upd_id = $conn->prepare("UPDATE update_belegung SET belegung_id =:belegung_id WHERE id = :id");
        $stmt_upd_belegung_ende = $conn->prepare("UPDATE belegung SET ende =:ende, updated_by='update_auto.php' WHERE id = :id");
        $stmt_lastid = $conn->prepare("SELECT LAST_INSERT_ID() as last_id");

        $heute = date('Y-m-d');        
        foreach($result as $belegung){
            
            $von = $belegung['von'];
            if(!$von){
                $von = $GLOBALS['hj_beginn'][$belegung['von_hj']-1];
            }
            if($von < $heute){
                $von = $heute;
            }

            $bis = $belegung['bis'];
            if(!$bis){
                $bis = $GLOBALS['hj_ende'][$belegung['bis_hj']-1];
            }

            //0 = aktuell laufende Belegung; -1 Belegung aus Vergangenheit; 1 Belegung in Zukunft
            $belegungstyp = 0;      
            if($bis < $heute){                
                $belegungstyp = -1;
            } else if($von > $heute){
                $belegungstyp = 1;
            }
            
            if($belegungstyp >=0){            
                
                $id = null;
                $schueler_id = null;
                $gruppe_id = null;

                $klabu_belegung = get_klabu_belegung($belegung);                
                if($klabu_belegung){                    
                    $gruppe_id = $klabu_belegung['gruppe_id'];  //get_klabu_gruppe_id($belegung);
                    $schueler_id = $klabu_belegung['schueler_id']; //get_klabu_schueler_id($belegung);

                    if($belegungstyp == 0){
                        if($klabu_belegung['beginn']<=$von 
                            && $klabu_belegung['ende']>=$von ){
                                $id = $klabu_belegung['id'];
                            }
                    } else if ($belegungstyp == 1){
                        if($klabu_belegung['beginn']==$von 
                        && $klabu_belegung['ende']==$bis){
                            $id = $klabu_belegung['id'];
                        }
                    }
                }
                
                if(!$id){
                    
                    $schueler_id = get_klabu_schueler_id($belegung);        
                    $gruppe_id = get_klabu_gruppe_id($belegung);
                    
                    /*
                    echo('<br>');
                    var_dump($belegung);
                    echo('<br>');
                    var_dump($klabu_belegung);
                    echo('<br>');

                    echo('<br>'.$gruppe_id);
                    echo('<br>'.$schueler_id);
                    echo('<br>');
                    */

                    $GLOBALS['report']->add("[INFO] Insert Belegung Schueler-ID: ".$schueler_id.", Gruppen-ID: ".$gruppe_id. " von ".$von." bis ".$bis. " update_belegung.id ".$belegung['id']);
                    
                    $stmt_ins->bindParam(':schueler_id',$schueler_id);
                    $stmt_ins->bindParam(':gruppe_id',$gruppe_id);
                    $stmt_ins->bindParam(':beginn',$von);
                    $stmt_ins->bindParam(':ende',$bis);
                    $stmt_ins->execute();

                    $stmt_lastid->execute();
                    $lastid_res = $stmt_lastid->fetch(PDO::FETCH_ASSOC);
                    $id = $lastid_res['last_id'];
                    
                    $stmt_upd_id->bindParam(':belegung_id',$id);
                    $stmt_upd_id->bindParam(':id',$belegung['id']);
                    $stmt_upd_id->execute();
        
                } else {
                    
                    
                    $stmt_upd_id->bindParam(':belegung_id',$id);
                    $stmt_upd_id->bindParam(':id',$belegung['id']);
                    $stmt_upd_id->execute();

                    if($bis != $klabu_belegung['ende'] && !$klabu_belegung['update_id']){
                        //Update des Ende-Datums in Belegung veranlassen.
                        $GLOBALS['report']->add("[INFO] Update Belegungs-End-Datum Schueler-ID: ".$schueler_id.", Gruppen-ID: ".$gruppe_id. " von ".$von." bis ".$bis. " update_belegung.id ".$belegung['id']." klabu_belegung.id ".$id);
                    
                        $stmt_upd_belegung_ende->bindParam(':ende',$bis);
                        $stmt_upd_belegung_ende->bindParam(':id',$id);
                        $stmt_upd_belegung_ende->execute();

                    } else {
                        $count++;
                    }

                }
            }

            if($belegungstyp==-1){
                $count_vergangene++;
            }
        }

        
        $GLOBALS['report']->add("[INFO] unveränderte Belegungen Count: ".$count);
        $GLOBALS['report']->add("[INFO] Ignorierte (bereits beendete) Belegungen Count: ".$count_vergangene);


        //Suche nach beendbaren Belegungen
        $stmt_del_b = $conn->prepare("SELECT b.*, g.name as kurs, s.vorname, s.nachname
                                        FROM belegung b
                                        LEFT JOIN gruppe g ON g.id = b.gruppe_id
                                        LEFT JOIN schueler s ON s.id = b.schueler_id
                                        LEFT JOIN update_belegung ub ON ub.belegung_id = b.id
                                        WHERE
                                        ub.id IS NULL
                                        AND
                                        b.ende >= :heute
                                        ");
        
        $stmt_del_b->bindParam(':heute',$heute);
        $stmt_del_b->execute();
        $result = $stmt_del_b->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $belegung){
            $GLOBALS['report']->add("[INFO] Beendbare Belegung Schueler: ".$belegung['vorname']." ".$belegung['nachname'].", Gruppen: ".$belegung['kurs'].", Klabu-ID: ".$belegung['id']);

            $stmt_upd_belegung_ende->bindParam(':ende',$heute);
            $stmt_upd_belegung_ende->bindParam(':id',$belegung['id']);
            $stmt_upd_belegung_ende->execute();
        }
    
        $conn = null;
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error');
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }

}





//Klassenbuch-Schüler-ID mittels übergebenem assoziativem Array bestimmen
//Vorrang hat dabei eine DanisID, dann eine Apollon/ID
function get_klabu_schueler_id($data){
    $schueler = get_klabu_schueler($data);
    if($schueler){
        return $schueler['id'];
    }
    return null;
}

function get_klabu_schueler($data){
    $a_id = null;
    if(isset($data['apollon_schueler_id'])){
        $a_id = $data['apollon_schueler_id'];
    }
    
    $d_id = null;
    if(isset($data['danis_schueler_id'])){
        $d_id = $data['danis_schueler_id'];
    }

    if(!$a_id && !$d_id){
        return null;
    }
  

    try {
        $db = new DB();
        $conn = $db->connect();
        if($a_id && $d_id){
            $stmt = $conn->prepare("SELECT s.*, us.id AS update_id
                                    FROM schueler s
                                    LEFT JOIN update_schueler us ON us.schueler_id = s.id
                                    WHERE
                                    s.danis_id = :d_id
                                    OR s.apollon_id = :a_id");
            $stmt->bindParam(':d_id',$d_id);
            $stmt->bindParam(':a_id',$a_id);
        } else if ($d_id){
            $stmt = $conn->prepare("SELECT s.*, us.id AS update_id
                                    FROM schueler s
                                    LEFT JOIN update_schueler us ON us.schueler_id = s.id
                                    WHERE
                                    s.danis_id = :d_id");
            $stmt->bindParam(':d_id',$d_id);            
        } else if ($a_id){
            $stmt = $conn->prepare("SELECT s.*, us.id AS update_id
                                    FROM schueler s
                                    LEFT JOIN update_schueler us ON us.schueler_id = s.id
                                    WHERE
                                    s.apollon_id = :a_id");
            $stmt->bindParam(':a_id',$a_id);            
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;

        if($result){
            return $result;
        }

        return null;
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error '.$ex->getMessage());
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }


}


//Klassenbuch-Gruppen-ID mittels übergebenem assoziativem Array bestimmen
//Vorrang hat dabei eine DanisID, dann ein Apollon-Kursname
function get_klabu_gruppe_id($data){
  $gruppe = get_klabu_gruppe($data);
  if($gruppe){
    return $gruppe['id'];
  }
  return null;
}

function get_klabu_gruppe($data){
    try {
        $db = new DB();
        $conn = $db->connect();

        $d_id = null;
        if(isset($data['danis_gruppe_id'])){
            $d_id = $data['danis_gruppe_id'];
            $stmt = $conn->prepare("SELECT g.*, l.kuerzel AS lehrer_kuerzel, ug.id AS update_id 
                                    FROM gruppe g 
                                    LEFT JOIN lehrer l ON l.id = g.lehrer_id 
                                    LEFT JOIN update_gruppe ug ON ug.gruppe_id = g.id
                                    WHERE g.danis_id = :d_id");
            $stmt->bindParam(':d_id',$d_id);            
            $stmt->execute();                       
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $conn = null;
                return $result;
            }
        }
       
    
        if(isset($data['apollon_gruppe_id'])&&isset($data['name'])){
            $name = $data['name'];
            $stmt = $conn->prepare("SELECT g.*, l.kuerzel AS lehrer_kuerzel, ug.id AS update_id 
                                    FROM gruppe g 
                                    LEFT JOIN lehrer l ON l.id = g.lehrer_id 
                                    LEFT JOIN update_gruppe ug ON ug.gruppe_id = g.id
                                    WHERE g.name = :name");
            $stmt->bindParam(':name',$name);            
            $stmt->execute();                       
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $conn = null;
                return $result;
            }
        }
               
        
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error '.$ex->getMessage());
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }
    
    return null;
}



//Klassenbuch-Lehrer-ID mittels übergebenem assoziativem Array bestimmen
//gesucht wird nach dem Feld "lehrer_kuerzel" oder "kuerzel"
function get_klabu_lehrer_id($data){
    $lehrer = get_klabu_lehrer($data);
    if($lehrer){
        return $lehrer['id'];
    }
    return null;
}

function get_klabu_lehrer($data){
    try {
        $db = new DB();
        $conn = $db->connect();
    
        $lehrer_kuerzel = null;
        if(isset($data['lehrer_kuerzel'])){
            $lehrer_kuerzel = $data['lehrer_kuerzel'];
        } 
        else if(isset($data['kuerzel'])){
            $lehrer_kuerzel = $data['kuerzel'];
        }
        
        if($lehrer_kuerzel){
            $stmt = $conn->prepare("SELECT l.*, ul.id as update_id 
                                    FROM lehrer l 
                                    LEFT JOIN update_lehrer ul ON ul.lehrer_id = l.id
                                    WHERE l.kuerzel = :lehrer_kuerzel");
            $stmt->bindParam(':lehrer_kuerzel',$lehrer_kuerzel);            
            $stmt->execute();                       
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $conn = null;
                return $result;
            }
        }
               
        
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error '.$ex->getMessage());
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }
    
    return null;
}



//Klassenbuch-Belegungs-ID mittels übergebenem assoziativem Array bestimmen
 function get_klabu_belegung($data){
    
    try {
        $db = new DB();
        $conn = $db->connect();
    
        $schueler_id = get_klabu_schueler_id($data);        
        $gruppe_id = get_klabu_gruppe_id($data);
    
        //Im Falle der Zuordbarkeit von Schüler und Gruppe die Belegung suchen,
        //welche zum aktuellen Tag passt beginn <= heute <= ende
        //
        //Zusätzlich mit update_id noch zurückgeben, ob die zugeordnete passende Belegung bereits einem anderen 
        //Update-Datensatz zugeordnet wurde (Sek.II -SuS sind bei Danis + Apollon in einem L1-Kurs.) Dies verhindert
        //Hin- und Heränderungen des ende-Datums (Danis = Schuljahresende, Apollon = bei Jg. 12 4. Semester)
        if($schueler_id && $gruppe_id){
            $heute = date('Y-m-d');
            $stmt = $conn->prepare("SELECT b.*, ub.id as update_id
                                    FROM belegung b 
                                    LEFT JOIN update_belegung ub ON ub.belegung_id = b.id
                                    WHERE schueler_id = :s_id 
                                    AND gruppe_id = :g_id
                                    AND beginn <= :heute
                                    AND ende >= :heute
                                    ");

            $stmt->bindParam(':s_id',$schueler_id);
            $stmt->bindParam(':g_id',$gruppe_id);            
            $stmt->bindParam(':heute',$heute);            
            $stmt->execute();                       
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $conn = null;
                return $result;
            }
        }
               
        
    } catch (PDOException $ex) {
        header('HTTP/1.0 500 Internal Server Error '.$ex->getMessage());
        die('{"error": {"message": "'.$ex->getMessage().'"}}');    
    }
    
    return null;
}


?>