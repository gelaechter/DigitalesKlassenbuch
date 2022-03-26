<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/*
// Allow preflight requests for /api/fach
$app->options('/api/fach', function (
    ServerRequestInterface $request, 
    ResponseInterface $response
): ResponseInterface {
    return $response;
});
*/

// Get - Alle Datensaetze
$app->get('/api/corona', function(Request $request, Response $response) {
    $json = Corona::read_all();    
    $response->getBody()->write($json);

    return $response;
});


// Get - Alle Datensaetze
$app->get('/api/corona/geimpfte/{bis}', function(Request $request, Response $response) {
    $json = Corona::count_geimpfte($request->getAttribute('bis'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - einzelner Datensatz
$app->get('/api/corona/gruppe/{id}', function(Request $request, Response $response) {
    $json = Corona::read_by_gruppe($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - alle Corona-Typen (Impfung, Schnelltest, ...)
$app->get('/api/corona/typen', function(Request $request, Response $response) {
    $json = Corona::read_corona_typen();    
    $response->getBody()->write($json);

    return $response;
});



//PUT - Datensatz aendern
$app->put('/api/corona/vorhanden/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $data["lehrer_id"]=$_SESSION["user_lehrer_id"];

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


        $stmt = $conn->prepare("UPDATE erledigung e SET e.bis = (SELECT v.bis FROM corona_vonbis v WHERE v.von <= e.von ORDER BY v.bis DESC LIMIT 1)  WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $json = Corona::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});




//POST - Datensatz aendern
$app->post('/api/corona/testneu', function(Request $request, Response $response) {
    
    $json = $request->getBody();
    $data = json_decode($json, true);

    $data["lehrer_id"]=$_SESSION["user_lehrer_id"];
    $data["eigenschaft_id"] = -2;

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


        $stmt = $conn->prepare("UPDATE erledigung e SET e.bis = (SELECT v.bis FROM corona_vonbis v WHERE v.von <= e.von ORDER BY v.bis DESC LIMIT 1)  WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data=array("erledigung_id" => $id, "corona_typen_id"=>1);
        $query = DB::create_insert_query('corona_typ', $data);
        $stmt = $conn->prepare($query);

        foreach ($data as $key => $val) {
            if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

            } else {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();

        $json = Corona::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});



//PUT - Datensatz aendern
$app->put('/api/corona/coronatyp/{id_ct}', function(Request $request, Response $response) {

    $id_ct = $request->getAttribute('id_ct');
    
    $json = $request->getBody();
    $data = json_decode($json, true);
    
    $query = DB::create_update_query('corona_typ', $data);

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

        $stmt->bindValue(':id', $id_ct);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT * FROM corona_typ WHERE id = :id_ct");
        $stmt->bindValue(':id', $id_ct);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $json = json_encode($result);

        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});


//POST - Datensatz hinzufügen
$app->post('/api/corona/coronatyp', function(Request $request, Response $response) {

    $json = $request->getBody();
    $data = json_decode($json, true);
    
    if(!$data['corona_typen_id'] || !$data['erledigung_id']){
        return;
    }

    $query = DB::create_insert_query('corona_typ', $data);

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
        $id_ct = $result[0];
        

        $stmt = $conn->prepare("SELECT * FROM corona_typ WHERE id = :id_ct");
        $stmt->bindValue(':id_ct', $id_ct);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $json = json_encode($result);
        
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});