<?php

use App\Controllers\UserController;

return [
    'GET' => [
        '/' => function () {
            echo json_encode(['message' => 'API is working!']);
        },

        '/users' => [UserController::class, 'index'],
        '/products' => function () {
            echo json_encode(['message' => 'Products list']);
        },
        '/health' => function () {
            echo json_encode(['status' => 'OK']);
        },

        '/users/{id}' => [UserController::class, 'show'],
        '/products/{id}' => function ($id) {
            echo json_encode(['message' => "Product $id"]);
        }
    ],

    'POST' => [
        '/users' => [UserController::class, 'store']
    ],

    'PUT' => [
        '/users/{id}' => [UserController::class, 'update']
    ],

    'DELETE' => [
        '/users/{id}' => [UserController::class, 'delete']
    ]
];