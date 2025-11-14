<?php

require_once "autoload.php";

use App\Router;
use App\Controllers\UserController;

$router = new Router();

$router->get('/', function () {
    echo json_encode(['message' => 'API is working!']);
});

$router->get('/users', [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);
$router->post('/users', [UserController::class, 'store']);
$router->put('/users/{id}', function ($id) {
    echo json_encode(['message' => "User $id updated"]);
});
$router->delete('/users/{id}', function ($id) {
    echo json_encode(['message' => "User $id deleted"]);
});

$router->dispatch();