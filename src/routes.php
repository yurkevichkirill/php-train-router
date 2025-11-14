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

        '#^/users/(?P<id>[^/]+)$#' => [UserController::class, 'show'],
        '#^/products/(?P<id>[^/]+)$#' => function ($id) {
            echo json_encode(['message' => "Product $id"]);
        },
        '#^/users/(?P<userId>[^/]+)/posts/(?P<postId>[^/]+)$#' => function ($userId, $postId) {
            echo json_encode(['user' => $userId, 'post' => $postId]);
        }
    ],

    'POST' => [
        '/users' => [UserController::class, 'store']
    ],

    'PUT' => [
        '#^/users/(?P<id>[^/]+)$#' => [UserController::class, 'update']
    ],

    'DELETE' => [
        '#^/users/(?P<id>[^/]+)$#' => [UserController::class, 'delete']
    ]
];