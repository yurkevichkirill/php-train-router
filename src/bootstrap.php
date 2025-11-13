<?php
require_once __DIR__ . '/core/Autoloader.php';

use Core\Autoloader;

Autoloader::register();
Autoloader::addNamespace('App', __DIR__ . '/app');
Autoloader::addNamespace('Core', __DIR__ . '/core');

echo "Custom autholoader initialized\n";