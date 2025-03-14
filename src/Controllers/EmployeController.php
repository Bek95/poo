<?php

namespace Controllers;

use Models\Employe;
class EmployeController
{
    public function __construct()
    {
        $employe = new \Models\Employe();
        echo "Controller Employé instancié" . PHP_EOL;
    }

}