<?php

require_once dirname(__DIR__,2) . "/autoload.php";

$app = new \web\App();
$app->authenticate()->render("Edit.php");

?>
