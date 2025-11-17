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

        '/users/{#^\w+$#}' => [UserController::class, 'show'],
        '/products/{#^\w+$#}' => function ($title) {
            echo json_encode(['message' => "Product $title"]);
        }
    ],

    'POST' => [
        '/users' => [UserController::class, 'store']
    ],

    'PUT' => [
        '/users/{#^\w+$#}' => [UserController::class, 'update']
    ],

    'DELETE' => [
        '/users/{#^\w+$#}' => [UserController::class, 'delete']
    ]
];