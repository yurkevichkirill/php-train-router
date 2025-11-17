<?php

require_once 'autoload.php';

use App\Router;

$routes = require __DIR__ . '/../src/routes.php';

$router = new Router($routes);

//$router->handler('http://localhost/', 'GET');
//$router->handler('http://localhost/users', 'GET');
//$router->handler('http://localhost/users/1', 'GET');

$router->handler('http://localhost/products/1', 'GET');

