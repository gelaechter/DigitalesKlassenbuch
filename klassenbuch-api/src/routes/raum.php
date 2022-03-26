<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Datensaetze
$app->get('/api/raum', function(Request $request, Response $response) {
    $json = Raum::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/raum/{id}', function(Request $request, Response $response) {
    $json = Raum::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});

