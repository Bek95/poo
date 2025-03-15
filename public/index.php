<?php

use App\Core\Autoloader;
use App\Core\Router;
use App\Controllers\HomeController;

require_once __DIR__ . '/../src/Core/Autoloader.php';

Autoloader::register();

// Instancier le routeur
$router = new Router();

// Enregistrer les routes
$router->register('', HomeController::class, 'index');

$router->register('/', HomeController::class, 'index');
$router->register('/test', HomeController::class, 'test');


// Dispatcher la requête
$router->dispatch();
