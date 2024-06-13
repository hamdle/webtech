<?php

$page = 'test';
$renderer = new \Api\Core\Renderer();
$path = dirname(__DIR__,1);

$renderer->render($path . '/Part/open.php');
$renderer->render($path . '/Part/header.php');
$renderer->render($path . '/Page/'.$page.'/index.html.php');
$renderer->render($path . '/Part/footer.php');
$renderer->render($path . '/Page/'.$page.'/script.js.php');
$renderer->render($path . '/Part/close.php');