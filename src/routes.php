<?php

use App\Controllers\UserController;

return [
    ['GET', '/', function () {
        echo json_encode(['message' => 'API is working!']);
    }],

    ['GET', '/users', [UserController::class, 'index']],
    ['GET', '/users/{id}', [UserController::class, 'show']],
    ['POST', '/users', [UserController::class, 'store']],
    ['PUT', '/users/{id}', [UserController::class, 'update']],
    ['DELETE', '/users/{id}', [UserController::class, 'delete']],

    ['GET', '/products', function () {
        echo json_encode(['message' => 'Products list']);
    }],

    ['GET', '/products/{id}', function ($id) {
        echo json_encode(['message' => "Product $id"]);
    }],

    ['GET', '/health', function () {
        echo json_encode(['status' => 'OK']);
    }]
];