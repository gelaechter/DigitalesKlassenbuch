<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Datensaetze
$app->get('/api/sitzplan', function (Request $request, Response $response) {
   
    $json = Sitzplan::read_all();
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/sitzplan/{id}', function (Request $request, Response $response) {
    $json = Sitzplan::read_single($request->getAttribute('id'));
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/sitzplan/gruppe/{gruppe}', function (Request $request, Response $response) {
    $json = Sitzplan::read_by_group($request->getAttribute('gruppe'));
    $response->getBody()->write($json);

    return $response;
});



// PUT - Status eines Datensatz aendern
$app->put('/api/sitzplan/status/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_update_query('sitzplan', $data);

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
        
        $json = Sitzplan::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }

});


// PUT - Datensatz aendern - nur möglich, wenn max. eine Verwendung des Planes vorliegt!
$app->put('/api/sitzplan/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $sitzplatz = $data['sitzplatz'];

    unset($data["sitzplatz"]);

    $query = DB::create_update_query('sitzplan', $data);

    try {
        //Prüfung auf Zulässigkeit der Anfrage
        $json = Sitzplan::read_single($id);
        
        $sitzplan = json_decode($json);
        $verwendungen = $sitzplan->{'verwendungen'};
        if($verwendungen > 1){
            throw new Exception('Sitzplan wegen der Verwendung in '.$verwendungen.' Unterrichten nicht mehr veränderbar.');
        }

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
        
        //Alle vorhandenen Sitzplatz-Einträge löschen
        $stmt = $conn->prepare('DELETE FROM sitzplatz WHERE sitzplan_id = :sitzplan_id');
        $stmt->bindValue(':sitzplan_id', $id);
        $stmt->execute();

        //Sitzplätze neu anlegen, falls solche übergeben wurden
        if(count($sitzplatz)>0){           
            $stmt = $conn->prepare("INSERT INTO sitzplatz(sitzplan_id, x, y, rot, schueler_id, `text`) VALUES (:sitzplan_id, :x, :y, :rot, :schueler_id, :text);");
            
            foreach($sitzplatz as $eintrag){
                
                $stmt->bindValue(':sitzplan_id', $id);
                $stmt->bindValue(':x', $eintrag["x"]);
                $stmt->bindValue(':y', $eintrag["y"]);
                $stmt->bindValue(':rot', $eintrag["rot"]);
                $stmt->bindValue(':schueler_id', $eintrag["schueler_id"]);
                $stmt->bindValue(':text', $eintrag["text"]);
                
                $stmt->execute();
            }
        }

        $stmt = $conn->prepare("INSERT INTO log(gruppe_id, user_iserv, `message`) VALUES (:gruppe_id, :user_iserv, :msg);");
        $stmt->bindValue(':gruppe_id', $data['gruppe_id']);
        $stmt->bindValue(':user_iserv', $_SESSION['user_iserv']);
        $stmt->bindValue(':msg', "Update von Sitzplan #".$id." vorgenommen.");
        $stmt->execute();

        $json = Sitzplan::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }

});


// POST - Datensatz neu anlegen 
$app->post('/api/sitzplan', function(Request $request, Response $response) {
    
    $json = $request->getBody();
    $data = json_decode($json, true);

    $sitzplatz = $data['sitzplatz'];
    unset($data["sitzplatz"]);

    $query = DB::create_insert_query('sitzplan', $data);

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
        

        
        //Sitzplätze neu anlegen, falls solche übergeben wurden
        if(count($sitzplatz)>0){           
            $stmt = $conn->prepare("INSERT INTO sitzplatz(sitzplan_id, x, y, rot, schueler_id, `text`) VALUES (:sitzplan_id, :x, :y, :rot, :schueler_id, :text);");
            
            foreach($sitzplatz as $eintrag){
                
                $stmt->bindValue(':sitzplan_id', $id);
                $stmt->bindValue(':x', $eintrag["x"]);
                $stmt->bindValue(':y', $eintrag["y"]);
                $stmt->bindValue(':rot', $eintrag["rot"]);
                $stmt->bindValue(':schueler_id', $eintrag["schueler_id"]);
                $stmt->bindValue(':text', $eintrag["text"]);
                
                $stmt->execute();
            }
        }

        $stmt = $conn->prepare("INSERT INTO log(gruppe_id, user_iserv, `message`) VALUES(:gruppe_id, :user_iserv, :msg);");
        $stmt->bindValue(':gruppe_id', $data['gruppe_id']);
        $stmt->bindValue(':user_iserv', $_SESSION['user_iserv']);
        $stmt->bindValue(':msg', "Neuer Sitzplan #".$id." angelegt.");
        $stmt->execute();

        $json = Sitzplan::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }

});