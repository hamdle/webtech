<?php

use Api\Core\Router;

require_once dirname(__DIR__, 2) . "/autoload.php";

$request = [
    'method' => 'Page.dash'
];

$get = isset($_GET["el"]) ? $_GET["el"] : null;
$exerciseList = $get ? explode(",", $get) : null;
\Api\Core\Context::set('exerciseList', $exerciseList);

$router = new Router();
$response = $router->handle($request);
$response->send();