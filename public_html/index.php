<?php

require_once dirname(__DIR__,1) . "/autoload.php";

$app = new \web\App();
$app->verifySession("/home")->render("Login.php");

?>
