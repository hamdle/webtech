<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $_ENV['APP_NAME']; ?> - <?php echo $_ENV['APP_NAME']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/x-icon" href="<?php echo $_ENV['ORIGIN']; ?>/img/favicon.ico">
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/vanilla.css" rel="stylesheet" type="text/css">
    <?php if (\App\Core\Utils\Helper::onPage("/workout/go") || \App\Core\Utils\Helper::onPage("/workout/timer")) { ?>
        <link href="<?php echo $_ENV['ORIGIN']; ?>/css/go.css" rel="stylesheet" type="text/css">
    <?php } ?>
</head>
<body>