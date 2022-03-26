<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Get - Alle Datensaetze
$app->get('/api/update/belegung', function(Request $request, Response $response) {
    $json = Update::check_belegung();    
    $response->getBody()->write($json);

    return $response;
});


// Get - Alle Datensaetze
$app->get('/api/update/schueler', function(Request $request, Response $response) {
    $json = Update::check_schueler();    
    $response->getBody()->write($json);

    return $response;
});


// Get - Alle Datensaetze
$app->get('/api/update/gruppe', function(Request $request, Response $response) {
    $json = Update::check_gruppe();    
    $response->getBody()->write($json);

    return $response;
});


