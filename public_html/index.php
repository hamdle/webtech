<?php

require_once dirname(__DIR__,1) . "/autoload.php";

$uri = $_SERVER["REQUEST_URI"];


$app = new \web\App();
$app->render($uri);

?>
