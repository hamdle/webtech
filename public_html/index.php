<?php

require_once dirname(__DIR__,1) . "/autoload.php";

$app = new \web\App();
$app->render($_SERVER["REQUEST_URI"]);

?>
