<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Datensaetze
$app->get('/api/unterricht', function(Request $request, Response $response) {
    $where_clause = DB::create_create_where_clause(json_decode($request->getBody(), true));

    $json = Unterricht::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/unterricht/{id}', function(Request $request, Response $response) {
    $json = Unterricht::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});

// GET - Unterrichte einer Gruppe im angegebenen Zeitraum
$app->get('/api/unterricht/gruppe/{gruppe}/datum/{von}/{bis}', function(Request $request, Response $response) {
    $json = Unterricht::read_by_gruppe_von_bis_plus($request->getAttribute('gruppe'), $request->getAttribute('von'), $request->getAttribute('bis'));    
    $response->getBody()->write($json);

    return $response;
});

// GET - Unterrichte eines Lehrers im angegebenen Zeitraum
$app->get('/api/unterricht/lehrer/{lehrer}/datum/{von}/{bis}', function(Request $request, Response $response) {
    $json = Unterricht::read_by_lehrer_von_bis($request->getAttribute('lehrer'), $request->getAttribute('von'), $request->getAttribute('bis'));    
    $response->getBody()->write($json);

    return $response;
});

// POST - Datensatz hinzufuegen
$app->post('/api/unterricht', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_insert_query('unterricht', $data);
    $msg = $query;

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
        $json = Unterricht::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "' . $ex->getMessage() . '", "query": "' . $msg . '" }}');
        return $response->withStatus(500);
    }
});

// PUT - Datensatz aendern
$app->put('/api/unterricht/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_update_query('unterricht', $data);

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
        $json = Unterricht::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }

});
