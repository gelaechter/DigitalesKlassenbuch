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
$app->get('/api/erledigung', function(Request $request, Response $response) {
    $json = Erledigung::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - Datensätze nach Gruppe und Eigenschaft
$app->get('/api/erledigung/gruppe/{id_g}/eigenschaft/{id_e}', function(Request $request, Response $response) {
    $json = Erledigung::read_by_gruppe($request->getAttribute('id_g'),$request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - Datensätze gruppiert nach Lehrer  - nach Eigenschaft und Gruppe
$app->get('/api/erledigung/lehrer/gruppe/{id_g}/eigenschaft/{id_e}', function(Request $request, Response $response) {
    $json = Erledigung::read_by_lehrer($request->getAttribute('id_g'),$request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});



// GET - Datensätze nach Schüler und Eigenschaft
$app->get('/api/erledigung/schueler/{id_s}/eigenschaft/{id_e}', function(Request $request, Response $response) {
    $json = Erledigung::read_by_schueler($request->getAttribute('id_s'),$request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});



// GET - einzelner Datensatz
$app->get('/api/erledigung/{id_e}', function(Request $request, Response $response) {
    $json = Erledigung::read_single($request->getAttribute('id_e'));    
    $response->getBody()->write($json);

    return $response;
});



// GET - zum Abrufzeitpunkt gültige Erledigungen Entschuldigung,Beurlaubung,Freistellung 
// in Abhängigkeit der Lerngruppe
$app->get('/api/erledigung/entschuldigung/aktuell/gruppe/{id_g}', function(Request $request, Response $response) {
    $json = Erledigung::read_entschuldigung_aktuell_by_gruppe($request->getAttribute('id_g'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - zum Abrufzeitpunkt ungültige Erledigungen zur Anzeige auf der Startseite
// in Abhängigkeit der Lerngruppe
$app->get('/api/erledigung/gruppe/{id_g}/startseite', function(Request $request, Response $response) {
    $json = Erledigung::read_erledigung_startseite_by_gruppe($request->getAttribute('id_g'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - Absenzenübersicht
// in Abhängigkeit eines Schülers
$app->get('/api/erledigung/entschuldigung/fehlzeitenuebersicht/{id_s}', function(Request $request, Response $response) {
    $json = Erledigung::read_fehlzeitenuebersicht($request->getAttribute('id_s'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - Statistik zur Eigenschaft -6 <=> Corona-Testausgabe
// jeweils für sieben Tage ab spezifiziertem Datum
$app->get('/api/erledigung/coronatestausgabe/wochenstatistik/{datum}', function(Request $request, Response $response) {
    $json = Erledigung::read_coronatestausgabe_wochenstatistik($request->getAttribute('datum'));    
    $response->getBody()->write($json);

    return $response;
});



// POST - Datensatz hinzufuegen
$app->post('/api/erledigung', function(Request $request, Response $response) {
    $json = $request->getBody();
    $data = json_decode($json, true);

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

        $json = Erledigung::read_single($id); 

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



//PUT - Datensatz aendern
$app->put('/api/erledigung/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $json = $request->getBody();
    $data = json_decode($json, true);
    

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


        $json = Erledigung::read_single($id); 
        $response->getBody()->write($json);
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
    }

    return $response;
});
