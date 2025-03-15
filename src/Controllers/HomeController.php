<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\Logger;

class HomeController {

    use Logger;
    public function index() {
        /*require __DIR__ . '/../Views/home.php';*/

        echo "Bienvenue dans la page d'accueil";
    }

    public function test() {
        /*require __DIR__ . '/../Views/home.php';*/

        try {
            $user = new User();
            $this->log("Creation d'un utilisateur","INFO");

        } catch (\Exception $e) {
            echo $e->getMessage();
        }


        echo "Bienvenue dans la page de test";
    }
}
