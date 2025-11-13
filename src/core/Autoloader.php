<?php
namespace Core;

class Autoloader {
    private static $prefixes = [];
    public static function register() {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }

    public static function addNamespace($prefix, $baseDir) {
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
        self::$prefixes[$prefix] = $baseDir;
    }

    public static function loadClass($className) {
        $prefix = $className;

        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($className, 0,$pos + 1);
            $relativeClass = substr($className, $pos + 1);
            $file = self::loadMappedFile($prefix, $relativeClass);
            if ($file) {
                return $file;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    private static function loadMappedFile($prefix, $relativeClass) {
        if (!isset(self::$prefixes[$prefix])) {
            return false;
        }

        $baseDir = self::$prefixes[$prefix];
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            return $file;
        }

        return false;
    }

    public static function getPrefixes() {
        return self::$prefixes;
    }

}