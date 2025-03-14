<?php

require_once "../autoload.php";

use App\Controllers\HomeController;
use App\Models\User;

$controller = new HomeController();
$controller->index();

$user = new User();
