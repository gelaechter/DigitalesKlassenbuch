<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Get - Alle Datensaetze
$app->get('/api/eigenschaft', function(Request $request, Response $response) {
    $json = Eigenschaft::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Datensatz
$app->get('/api/eigenschaft/{id}', function(Request $request, Response $response) {
    $json = Eigenschaft::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


// GET - einzelner Datensatz
$app->get('/api/eigenschaft/gruppe/{id}', function(Request $request, Response $response) {
    $json = Eigenschaft::read_by_group($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});


