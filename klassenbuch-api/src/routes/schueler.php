<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Schueler
$app->get('/api/schueler', function(Request $request, Response $response) {
    $json = Schueler::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Schueler
$app->get('/api/schueler/{id}', function(Request $request, Response $response) {
    $json = Schueler::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - einzelner Schueler oder Lehrer via RFID
$app->get('/api/rfid/{rfid}', function(Request $request, Response $response) {
    $json = Schueler::read_by_rfid($request->getAttribute('rfid'));    
    $response->getBody()->write($json);

    return $response;
});



//PUT - Datensatz aendern
$app->put('/api/schueler/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);
    

    $query = DB::create_update_query('schueler', $data);

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


        $json = Schueler::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});




// POST - Datensatz hinzufuegen
$app->post('/api/schueler', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

    $query = DB::create_insert_query('schueler', $data);

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

        $json = Schueler::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;

    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});
