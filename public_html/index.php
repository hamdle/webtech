<?php

use Api\Core\Router;

require_once dirname(__DIR__, 1) . "/autoload.php";

$request = [
    'method' => 'Page.login'
];

$router = new Router();
$response = $router->handle($request);
$response->send();