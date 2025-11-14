<?php

spl_autoload_register(static function ($class_name) {
    $class_name = str_replace('App\\', '', $class_name);

    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class_name) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});