<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Paths;

$app = new App(Paths::SOURCE . "app/container-definitions.php");
// composer does not support autoload for functions, only classes, manually tell composer to load file
registerRoutes($app);
registerMiddleware($app);

return $app;
