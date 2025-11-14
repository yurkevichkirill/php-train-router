<?php

require_once 'autoload.php';

use App\Router;

$routes = require __DIR__ . '/../src/routes.php';

$router = new Router();
$router->dispatch($routes);