<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET - einzelner Datensatz
$app->get('/api/praesenz_gruppe/{gruppe_id}', function(Request $request, Response $response) {
    $json = PraesenzGruppe::read_by_gruppe($request->getAttribute('gruppe_id'));    
    $response->getBody()->write($json);

    return $response;
});

