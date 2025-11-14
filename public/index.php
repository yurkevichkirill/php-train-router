<?php

require_once "autoload.php";

use App\Router;

$router = new Router();

$routes = require __DIR__ . "/../src/routes.php";
$router->addRoutes($routes);

$router->dispatch();