<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Workout app.</title>
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="dash__body">
    <div class="dash__wrap">
        <div class="dash__display dash__display--header">
            <div class="header__body">
                <div class="header__wrap">
                    <?php
                        $session = new \Models\Session();
                        $session->verify();
                        $user = $session->user;
                    ?>
                    <div class="header__title">Workout.dev <span class="fa fa-astro footer__icon"></span> Dashboard <span class="header__user"><span class="fa fa-user footer__icon"></span><?php echo $user->email; ?></span></div>
                    <div class="header__menu">
                    </div>
                </div>
            </div>
        </div>

        <div class="dash__display dash__display--log">
            <div class="dash__body">
                <div class="dash__button-start"><div class="button"><a class="dash__link" href="/go">New <span class="fa fa-bike footer__icon"></span> workout</a></div></div>
                <div id="log" class="log"></div>
            </div>
        </div>

    </div>
    <footer class="footer__login">
            <a href="https://github.com/hamdle/workout-web-app" target="_blank">
                <div class="footer__wrap">Workout.dev
                    <span class="fa fa-info footer__icon"></span> version
                    <b><?php echo $_ENV['VERSION']; ?></b>
                    <span class="fa fa-dash footer__icon"></span>
                    <span class=""><span class="fa fa-connection footer__icon"></span>
                        <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
                    </span>
                </div>
            </a>
    </footer>

    <script>
        let api = "http://workout.local/api/";
        let site = "http://workout.local/";
    </script>
    <script src="/../js/components/verifyuser.js"></script>
    <script src="/../js/components/log.js"></script>
    <script>
        Log.init();
        // VerifyUser.onSuccess(function() {
        //     Log.init();
        //     Version.init();
        // });
    </script>
</div>
</body>
</html>