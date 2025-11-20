<?php

require_once 'autoload.php';

use App\Router;

$routes = require __DIR__ . '/../src/routes.php';

$router = new Router();

$router->initializeControllers();

echo "<pre>";
var_dump($router->routes);
echo "</pre>";

//$router->handler('http://localhost/', 'GET');
//$router->handler('http://localhost/users', 'GET');
//$router->handler('http://localhost/users/1', 'GET');
echo "<pre>";
$router->handler('http://localhost/users/1', 'GET');
echo "</pre>";

