<?php

spl_autoload_register(function ($class) {
    // Remplace le namespace par le chemin du dossier
    $class = str_replace("App\\", "src/", $class);
    $class = str_replace("\\", "/", $class);

    $file = __DIR__ . "/" . $class . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
});
