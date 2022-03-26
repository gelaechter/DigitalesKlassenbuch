<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Datensaetze
$app->get('/api/praesenz', function(Request $request, Response $response) {
    $json = Praesenz::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/praesenz/{id}', function(Request $request, Response $response) {
    $json = Praesenz::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});

// POST - Datensatz hinzufuegen
$app->post('/api/praesenz', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_insert_query('praesenz', $data);

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
        $json = Praesenz::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }
});

// PUT - Datensatz aendern
$app->put('/api/praesenz/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_update_query('praesenz', $data);

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
        $json = Praesenz::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }
});
