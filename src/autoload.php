<?php
spl_autoload_register(static function ($class_name) {
    $path = str_replace(['App\\', 'Core\\'], '', $class_name);
    $file = __DIR__ . '/' . str_replace('\\', '/', $path) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});