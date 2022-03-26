<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Get - Alle Datensaetze
$app->get('/api/zustimmung', function(Request $request, Response $response) {
    $json = Zustimmung::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/zustimmung/{id}', function(Request $request, Response $response) {
    $json = Zustimmung::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});

// GET - zu signierende Datensätze
$app->get('/api/zustimmung/lehrer/{id}', function(Request $request, Response $response) {
    $json = Zustimmung::read_by_lehrer($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// PUT - Datensatz aendern
$app->put('/api/zustimmung/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_update_query('zustimmung', $data);

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
        $json = Zustimmung::read_single($id);
        $response->getBody()->write($json);
        $conn = null;
        return $response;
    } catch (PDOException $ex) {
        $response->getBody()->write('{"error": {"message": "'.$ex->getMessage().'"}}');
        return $response->withStatus(500);
    }

});