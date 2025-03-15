<?php

namespace App\Core;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Vérifie que la classe appartient bien à "App"
            if (strpos($class, 'App\\') === 0) {
                // Convertit les namespaces en chemins de fichiers
                $class = str_replace('App\\', '', $class);
                $file = __DIR__ . '/../../src/' . str_replace('\\', '/', $class) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                } else {
                    die("Class not found: " . $file);
                }
            }
        });
    }
}
