<?php

use Api\Core\Router;

require_once dirname(__DIR__, 2) . "/autoload.php";

$request = [
    'method' => 'Page.test'
];

$router = new Router();
$response = $router->handle($request);
$response->send();