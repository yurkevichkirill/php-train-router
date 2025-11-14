<?php

require_once 'autoload.php';

use App\Router;

echo "=== START DEBUG ===\n";

// Проверяем автолоад
if (class_exists('App\Router')) {
    echo "✓ Router class loaded\n";
} else {
    echo "✗ Router class NOT loaded\n";
    exit;
}

// Простые тестовые роуты
$routes = [
    ['GET', '/', function () {
        echo "✅ Root route WORKS!\n";
    }],
    ['GET', '/test', function () {
        echo "✅ Test route WORKS!\n";
    }],
    ['GET', '/users/{id}', function ($id) {
        echo "✅ User route WORKS! ID: $id\n";
    }]
];

echo "Routes defined: " . count($routes) . "\n";

// Создаем роутер
$router = new Router();

// Имитируем запрос к корню
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';

echo "Dispatching: {$_SERVER['REQUEST_METHOD']} {$_SERVER['REQUEST_URI']}\n";

// Запускаем
$router->dispatch($routes);

echo "=== END DEBUG ===\n";