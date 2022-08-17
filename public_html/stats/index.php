<?php

require_once dirname(__DIR__,2) . "/autoload.php";

$app = new \web\App();
$app->verifySession()->render("Stats.php");

?>
