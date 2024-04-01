<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Controllers\HomeController;


$app = new App();

//$app->get('/', ['App\Controllers\HomeController', 'home']); // register homecontroller, "GET" method add to router
//wrapping value in array - after instance created , next step run the method for displaying the pages contents
$app->get('/', [HomeController::class, 'home']); // helps avoid typos


return $app;
