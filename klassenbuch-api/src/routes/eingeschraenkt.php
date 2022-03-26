<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle 
$app->get('/api/eingeschraenkt/gruppe', function(Request $request, Response $response) {

    $json = Eingeschraenkt::gruppe_read_all();
    $response->getBody()->write($json);
    
    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/eingeschraenkt/gruppe/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    
    $json = Eingeschraenkt::gruppe_read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - einzelner Schueler
$app->get('/api/eingeschraenkt/schueler/{id}', function(Request $request, Response $response) {
    $json = Eingeschraenkt::schueler_read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - Datensätze nach Schüler und Eigenschaft
$app->get('/api/eingeschraenkt/erledigung/schueler/{id_s}/eigenschaft/{id_e}', function(Request $request, Response $response) {
    $json = Eingeschraenkt::erledigung_read_by_schueler($request->getAttribute('id_s'),$request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - Absenzenübersicht
// in Abhängigkeit eines Schülers
$app->get('/api/eingeschraenkt/erledigung/entschuldigung/fehlzeitenuebersicht/{id_s}', function(Request $request, Response $response) {
    $json = Eingeschraenkt::erledigung_read_fehlzeitenuebersicht($request->getAttribute('id_s'));    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/eingeschraenkt/erledigung/{id_e}', function(Request $request, Response $response) {
    $json = Eingeschraenkt::erledigung_read_single($request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});




//PUT - Datensatz aendern
$app->put('/api/eingeschraenkt/erledigung/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $rawdata = json_decode($json, true);
    $data = array();

    //Zulässige Änderungen durch Schüler sind nur:
    //a) Änderung des Start-Datums, wenn noch kein Endedatum und kein Signum gesetzt.
    //b) Setzen des Enddatums, wenn dies vorher "Null" war und dieses größergleich dem von-Datum ist
    //c) Löschung des Vorgangs, wenn noch kein Signum gesetzt.
    //und immer nur an Entschuldigungen (eigenschaft_id=-3) und privaten Beurlaubungen (id=-4) zulässig
    $erlaubt = false;

    $json = Erledigung::read_single($id);
    $erledigung = json_decode($json, true);

    if($rawdata['von'] && !$erledigung['lehrer_id'] && !$erledigung['bis']){
        $erlaubt = true;
        $data["von"] = $rawdata["von"];
    }

    if($rawdata['geloescht'] && !$erledigung['lehrer_id']){
        $erlaubt = true;
        $data["geloescht"] = 1;
    }

    if($rawdata["bis"] && !$erledigung['lehrer_id'] && $rawdata["bis"]>=$erledigung['von']){
        $erlaubt = true;
        $data["bis"] = $rawdata["bis"];
    }

    if($erledigung["eigenschaft_id"]!=-3 && $erledigung["eigenschaft_id"]!=-4){
        $erlaubt = false;
    }



    if(!$erlaubt){
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    }

    $query = DB::create_update_query('erledigung', $data);

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($query);

        foreach ($data as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $stmt->bindValue(':' . $key, $val);
            }
        }

        $stmt->bindValue(':id', $id);
        $stmt->execute();


        

        $json = Eingeschraenkt::erledigung_read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});




// POST - Datensatz hinzufuegen
$app->post('/api/eingeschraenkt/erledigung', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);
    
    

    //Zulässiges Einfügen durch Schüler nur:
    //Entschuldigungen und Urlaubsanträge
    //nie Lehrer-Signum  
    //Entschuldigungen nur mit einem Enddatum <= heute.
    //Beurlaubungen nur mit von und bis - Datum

    //bei Beurlaubungen, welche mehr als zwei Tage umfassen: Zustimmung DM

    $erlaubt = true;

    if($data["lehrer_id"]){
        $erlaubt = false;        
    }

    if($data["eigenschaft_id"]!=-3 && $data["eigenschaft_id"]!=-4){
        $erlaubt = false;
    }

    if(!$data["von"]){
        $erlaubt = false;        
    }

    if($data['bis'] && $data['bis'] < $data["von"]){
        $erlaubt = false;        
    }

    $heute = date("Y-m-d"); 
    if($data["eigenschaft_id"]==-3 && $data['bis'] && $data["bis"] > $heute){
        $erlaubt = false;        
    }

    if($data["eigenschaft_id"]==-4 && (!$data["bis"] || !$data["von"])){
        $erlaubt = false;        
    }



    if(!$erlaubt){
        $response->getBody()->write(json_encode($json));
        $conn = null;
        return $response;
    }


    

    $query = DB::create_insert_query('erledigung', $data);

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($query);

        foreach ($data as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $stmt->bindValue(':' . $key, $val);
            }
        }

        
        $stmt->execute();
        $query = 'SELECT LAST_INSERT_ID()';
        $stmt = $conn->query($query);

        $result = $stmt->fetch(PDO::FETCH_NUM);
        $id = $result[0];
        
        
        $json = Eingeschraenkt::erledigung_read_single($id); 

        $erledigung = json_decode($json, true);
        
        //Beurlaubungen > 2 Tage automatisch an Schulleiter verweisen
        //auch noch differenziert an Jahrgangskoordinatoren möglich.
        //Beim Update muss das auch noch hin
        //in die nicht-eingeschraenkte Route auch noch.        
        if($erledigung["eigenschaft_id"]==-4){
            $origin = new DateTime($erledigung['von']);
            $target = new DateTime($erledigung['bis']);
            $interval = $origin->diff($target);

            if($interval->d > 2){
                $data=array();
                $data['lehrer_id'] = 4;
                $data['erledigung_id'] = $id;
                $data['info'] = "Genehmigung Schulleiter";
                $query = DB::create_insert_query('zustimmung', $data);
                $stmt_z = $conn->prepare($query);
                $stmt_z->bindParam(':lehrer_id', $data['lehrer_id']);
                $stmt_z->bindParam(':erledigung_id', $data['erledigung_id']);
                $stmt_z->bindParam(':info', $data['info']);
                $stmt_z->execute();
            }
        }
        
        
        //Bei der Anlage einer Entschuldigung oder privaten Beurlaubung immer Zustimmungspflicht von 
        //Eltern und Tutor(in)
        //sofern es Schüler der Sek. II sind
        if(($erledigung['eigenschaft_id'] == -4 || $erledigung['eigenschaft_id'] == -3) && $erledigung['schueler']['apollon_id']){
            
            $tutor_id = 39;
            if($erledigung['schueler']['gruppe_id']!=null){
                $tutoriat = json_decode(Gruppe::read_single($erledigung['schueler']['gruppe_id']) ,true);
                $tutor_id = $tutoriat['lehrer_id'];
            }            

            $data=array();
            
            $data['erledigung_id'] = $erledigung['id'];
            $data['lehrer_id'] = $tutor_id;
            $data['info'] = "Tutor";
            $query = DB::create_insert_query('zustimmung', $data);
            $stmt_zs = $conn->prepare($query);
            
            $stmt_zs->bindParam(':erledigung_id', $data['erledigung_id']);
            $stmt_zs->bindParam(':lehrer_id', $data['lehrer_id']);
            $stmt_zs->bindParam(':info', $data['info']);
            $stmt_zs->execute();

            $data = array();
            $data['erledigung_id'] = $erledigung['id'];
            $data['info'] = "Eltern";        
            $query = DB::create_insert_query('zustimmung', $data);
            $stmt_zs = $conn->prepare($query);                
            $stmt_zs->bindParam(':erledigung_id', $data['erledigung_id']);
            $stmt_zs->bindParam(':info', $data['info']);
            $stmt_zs->execute();

            //Hier dann noch ggf. Freischaltung eines Externen-Links zum Unterschreiben
            //zustimmungExtern(id, ^zustimmung_id, geheimnis, ablaufdatum)
        
        }



        $response->getBody()->write($json);
        $conn = null;

    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});



//PUT - Datensatz aendern  nicht möglich.
$app->put('/api/eingeschraenkt/mitteilung/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);
        
    try {
        $json = Mitteilung::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});




// POST - Datensatz hinzufuegen
$app->post('/api/eingeschraenkt/mitteilung', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_insert_query('mitteilung', $data);

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($query);

        foreach ($data as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $stmt->bindValue(':' . $key, $val);
            }
        }

        
        $stmt->execute();
        $query = 'SELECT LAST_INSERT_ID()';
        $stmt = $conn->query($query);

        $result = $stmt->fetch(PDO::FETCH_NUM);
        $id = $result[0];

        $json = Mitteilung::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;

    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});
