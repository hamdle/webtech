<?php

require_once dirname(__DIR__,1) . "/autoload.php";

$uri = $_SERVER["REQUEST_URI"];
$uri = str_replace('/','',$uri);

$template = empty($uri)
    ? "Login.php"
    : ucwords(str_replace('/','',$uri)).".php";

$app = new \web\App();
$app->render($template);

?>
