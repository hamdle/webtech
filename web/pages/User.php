<?php
$this->verifyOrDie();
$user = $this->session->user;
?>
<!DOCTYPE html>
<html>
<head>
    <title>User - Workout app.</title>
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
                            User
                            <span class="header__user">
                                <span class="header__actions">
                                    <span class="header__links">
                                        <a id="logout" class="action" href="/logout">Logout</a>
                                    </span>
                                </span>
                                <span class="fa fa-user footer__icon"></span>
                                <span class="header__links">
                                    <?php echo $user->email; ?>
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
                    <div class="user__field"><span class="fa fa-user user__icon"></span></div>
                    <div class="user__field">Name: <span class="user__value"><?php echo $user->first_name; ?></span></div>
                    <div class="user__field">Email: <span class="user__value"><?php echo $user->email; ?></span></div>
                    <div class="user__field">Created on: <span class="user__value"><?php echo $user->created_date; ?></span></div>
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

    <?php include dirname(__DIR__, 1)."/templates/Javascript.php"; ?>

    <script src="/../js/components/logout.js"></script>
    <script>
        Logout.init(document.getElementById("logout"));
    </script>
</body>
</html>