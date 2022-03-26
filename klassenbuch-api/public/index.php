<?php

require '../../klassenbuch/auth.php';



use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use \Slim\Routing\RouteContext;

//require '../../../openid/auth.php';

require_once __DIR__ . '/../vendor/autoload.php';
require '../src/config/DB.php';
require '../src/models/Schueler.php';
require '../src/models/Gruppe.php';
require '../src/models/Lehrer.php';
require '../src/models/Fach.php';
require '../src/models/Belegung.php';
require '../src/models/UStunde.php';
require '../src/models/Unterricht.php';
require '../src/models/Praesenz.php';
require '../src/models/PraesenzGruppe.php';
require '../src/models/Raum.php';
require '../src/models/Sitzplan.php';
require '../src/models/Corona.php';
require '../src/models/Erledigung.php';
require '../src/models/Update.php';
require '../src/models/Mitteilung.php';
require '../src/models/Eingeschraenkt.php';
require '../src/models/Zustimmung.php';
require '../src/models/Eigenschaft.php';


$app = AppFactory::create();
$app->setBasePath('/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api');

//https://akrabat.com/running-slim-4-in-a-subdirectory/
//https://www.slimframework.com/docs/v4/cookbook/enable-cors.html



// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));


//https://odan.github.io/2019/11/24/slim4-cors.html
//$app->add(Slim\Middleware\CorsMiddleware::class);


// Add Slim routing middleware
$app->addRoutingMiddleware();


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response->withStatus(200);
});




$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    
    return $response
    ->withHeader('Access-Control-Allow-Origin', 'https://jag-emden.de')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->withHeader('Access-Control-Allow-Credentials', 'true');
});



$app->addErrorMiddleware(true, true, true);

// Define app routes

$app->get('/', function (Request $request, Response $response) {
    //$routeContext = RouteContext::fromRequest($request);
    //$basePath = $routeContext->getBasePath();
    $text = 'User-Lehrer-ID: '.$_SESSION['user_lehrer_id']."<br>";
    $text .= 'User-Schueler-ID: '.$_SESSION['user_schueler_id']."<br>";
    $text .= $_SESSION['name']."<br>";
    $text .= var_export($_SESSION['email'], true)."<br>"; 
    $text .= var_export($_SESSION['groups'], true)."<br>"; 
    $text .= var_export($_SESSION['userinfo'], true); 
    
    $response->getBody()->write($text);
    return $response;
});



// Routen für jeden Benutzer
require '../src/routes/ustunde.php';
require '../src/routes/raum.php';


// Routen  nur für Lehrer
$lehrer_id = $_SESSION['user_lehrer_id'];
$schueler_id = $_SESSION['user_schueler_id'];
if($lehrer_id || $lehrer_id !== null){
    require '../src/routes/fach.php';
    require '../src/routes/schueler.php';
    require '../src/routes/lehrer.php';
    require '../src/routes/gruppe.php';
    require '../src/routes/belegung.php';
    require '../src/routes/unterricht.php';
    require '../src/routes/praesenz.php';
    require '../src/routes/praesenz_gruppe.php';
    require '../src/routes/sitzplan.php';
    require '../src/routes/corona.php';
    require '../src/routes/erledigung.php';
    require '../src/routes/update.php';
    require '../src/routes/mitteilung.php';
    require '../src/routes/zustimmung.php';
    require '../src/routes/eigenschaft.php';

}

// Routen für Schüler (und auch Lehrer)
require '../src/routes/eingeschraenkt.php';



/**
 * Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 * 
 */

 $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request) {
    throw new HttpNotFoundException($request);
});
 



// Run app
$app->run();