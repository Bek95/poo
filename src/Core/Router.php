<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function register(string $uri, string $controller, string $method = 'index')
    {
        $this->routes[$uri] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');// nettoyage de l'url

        if (isset($this->routes["/$uri"])) {
            $controller = $this->routes["/$uri"]['controller'];
            $method = $this->routes["/$uri"]['method'];
        } else {
            die("Route '$uri' non trouvée.");
        }

        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                die("Méthode '$method' non trouvée dans le contrôleur $controller.");
            }
        } else {
            die("Contrôleur '$controller' non trouvé.");
        }
    }
}
