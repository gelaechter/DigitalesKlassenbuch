<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function readSingleUStunde($id) {
    $query = 'SELECT * FROM ustunde WHERE id = :id';

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return json_encode($result);
}

// Get - Alle Datensaetze
$app->get('/api/ustunde', function(Request $request, Response $response) {
    $json = UStunde::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// Get - Alle Datensaetze zum Anzeigen
$app->get('/api/ustunde/anzeige', function(Request $request, Response $response) {
    $json = UStunde::read_anzeigen();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/ustunde/{id}', function(Request $request, Response $response) {
    $json = UStunde::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


//GET - Stunde, welche möglichst nah an übergebener Zeit startet
$app->get('/api/ustunde/beginn/{time}', function(Request $request, Response $response) {        
    $json = UStunde::read_single_by_beginn($request->getAttribute('time'));        
    $response->getBody()->write($json);

    return $response;
});


//GET - Stunde, welche möglichst nah an übergebener Zeit endet
$app->get('/api/ustunde/ende/{time}', function(Request $request, Response $response) {        
    $json = UStunde::read_single_by_ende($request->getAttribute('time'));        
    $response->getBody()->write($json);

    return $response;
});



// POST - Datensatz hinzufuegen
$app->post('/api/ustunde', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_insert_query('ustunde', $data);

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
        $json = UStunde::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});

// PUT - Datensatz aendern
$app->put('/api/ustunde/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_update_query('ustunde', $data);

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
        $json = UStunde::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});
