<?php


use Controllers\HomeController;
use Controllers\EmployeController;

// Récupérer la route depuis l'URL (ex: /?route=employe)
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Définition des routes possibles
$routes = [
    'home' => HomeController::class,
    'employe' => EmployeController::class,
];

if (array_key_exists($route, $routes)) {
    $controllerName = $routes[$route];
    $controller = new $controllerName();
    $controller->index(); // Appelle la méthode index du contrôleur
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
