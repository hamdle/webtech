<?php

use App\Core\Router;

require_once dirname(__DIR__, 3) . "/autoload.php";

$request = [
    'method' => 'Workout.go'
];

$get = isset($_GET["el"]) ? $_GET["el"] : null;
$exerciseList = $get ? explode(",", $get) : null;
\App\Core\Context::set('exerciseList', $exerciseList);

$router = new Router();
$response = $router->handle($request);
$response->send();