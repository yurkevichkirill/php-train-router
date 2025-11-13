<?php
require_once __DIR__ . '/bootstrap.php';

use App\Controllers\UserController;
use App\Models\User;
use Core\Database\Connection;

echo "Testing CUSTOM autoload...\n";

$controller = new UserController();
echo "UserController loaded\n";

$user = new User("Test User");
echo "User model loaded: " . $user->getName() . "\n";

$db = new Connection();
echo "Database Connection loaded: " . $db->connect() . "\n";

echo "Controller method: " . $controller->index() . "\n";
echo "Controller method with params: " . $controller->show(123) . "\n";

echo "CUSTOM AUTOLOAD WORKS PERFECTLY!\n";

$prefixes = Core\Autoloader::getPrefixes();
echo "\nRegistered namespaces:\n";
foreach ($prefixes as $prefix => $path) {
echo "  {$prefix} => {$path}\n";
}