<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuthController, TransactionController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app) {
    //$app->get('/', ['App\Controllers\HomeController', 'home']); // register homecontroller, "GET" method add to router
    //wrapping value in array - after instance created , next step run the method for displaying the pages contents
    $app->get('/', [HomeController::class, 'home'])->add(AuthRequiredMiddleware::class); // helps avoid typos
    $app->get('/about', [AboutController::class, 'about']);
    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/logout', [AuthController::class, 'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction', [TransactionController::class, 'createView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction', [TransactionController::class, 'create'])->add(AuthRequiredMiddleware::class);
}
