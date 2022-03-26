<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get - Alle Lehrer
$app->get('/api/lehrer', function(Request $request, Response $response) {
    $json = Lehrer::read_all();    
    $response->getBody()->write($json);

    return $response;
});

// GET - einzelner Lehrer
$app->get('/api/lehrer/{id}', function(Request $request, Response $response) {
    $json = Lehrer::read_single($request->getAttribute('id'));    
    $response->getBody()->write($json);

    return $response;
});

