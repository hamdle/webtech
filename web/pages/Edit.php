<?php

$user = $this->session->user;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit - Workout app.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="dash__body">
    <div class="dash__wrap">
        <div class="dash__display dash__display--header">
            <div class="header__body">
                <div class="header__wrap">
                    <div class="header__title"><a class="link" href="/home">Workout.dev</a> <span class="fa fa-right-arrow footer__icon"></span>
                        Edit workout
                        <span class="header__user">
                            <span class="header__actions">
                                <span class="header__links">
                                    <a class="action" href="/delete">Delete</a>
                                </span>
                            </span>
                            <span class="fa fa-user footer__icon"></span>
                            <span class="header__links">
                                <a class="link" href="/user/"><?php echo $user->email; ?></a>
                            </span>
                        </span>
                    </div>
                    <div class="header__menu">
                    </div>
                </div>
            </div>
        </div>

        <div class="dash__display dash__display--log">
            <div class="dash__body">
                Edit workout
            </div>
        </div>

    </div>
    <footer class="footer__login">
        <div class="footer__wrap--bottom">
            <a href="https://github.com/hamdle/workout-web-app" class="link" target="_blank">Workout.dev</a>
            <span class="fa fa-info footer__icon"></span> version
            <b><?php echo $_ENV['VERSION']; ?></b>
            <span class="fa fa-dash footer__icon"></span>
            <span class=""><span class="fa fa-connection footer__icon"></span>
                    <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
                </span>
        </div>
    </footer>
</div>
</body>
</html>