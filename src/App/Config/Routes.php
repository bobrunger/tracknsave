<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuthController};

function registerRoutes(App $app) {
    //$app->get('/', ['App\Controllers\HomeController', 'home']); // register homecontroller, "GET" method add to router
    //wrapping value in array - after instance created , next step run the method for displaying the pages contents
    $app->get('/', [HomeController::class, 'home']); // helps avoid typos
    $app->get('/about', [AboutController::class, 'about']);
    $app->get('/register', [AuthController::class, 'registerView']);
    $app->post('/register', [AuthController::class, 'register']);
}
