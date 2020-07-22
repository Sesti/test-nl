<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $path = parse_url($_SERVER['REQUEST_URI'])['path'];
// $scriptName = dirname(dirname($_SERVER['SCRIPT_NAME']));
// $len = strlen($scriptName);
// if ($len > 0 && $scriptName !== '/') {
//     $path = substr($path, $len);
// }
// $_SERVER['REQUEST_URI'] = $path ?: '';

$app = AppFactory::create();

$app->addRoutingMiddleware();

//Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();