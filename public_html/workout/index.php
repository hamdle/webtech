<?php

use App\Core\Router;

require_once dirname(__DIR__, 2) . "/autoload.php";

$request = [
    'method' => 'Workout.home'
];

$router = new Router();
$response = $router->handle($request);
$response->send();