<?php
require_once __DIR__ . '/../autoload.php';

use App\Controllers\UserController;
use App\Models\User;
use Core\Database\Connection;

$controller = new UserController();
$user = new User("Test User");
$db = new Connection();

echo $controller->index() . "\n";
echo $controller->show(123) . "\n";
echo $db->connect() . "\n";