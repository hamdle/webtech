<?php

use App\Core\Router;
use App\Core\Http\Request;

require_once dirname(__DIR__, 2) . "/autoload.php";

$request = Request::post();

$router = new Router();
$response = $router->handle($request);
$response->send();