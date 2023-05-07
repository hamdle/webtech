<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Workout.dev</title>
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php //include __DIR__.'/template.html'; ?>

<div class="login__body">
    <div class="login__wrap">
        <div class="login-form__wrap">
            <form id="loginForm" class="login__form">
                <h1 class="login__header">404 - Page Not Found</h1>
            </form>
        </div>
    </div>
    <footer class="footer__login">
        <div class="footer__wrap--bottom">
            <a href="https://github.com/hamdle/workout-web-app" class="link"  target="_blank">Workout.dev</a> <span class="fa fa-info footer__icon"></span> version <b><?php echo $_ENV['VERSION']; ?></b> <span class="fa fa-dash footer__icon"></span><span class=""><span class="fa fa-connection footer__icon"></span> <b><?php echo $_ENV['ENVIRONMENT']; ?></b></span>
        </div>
    </footer>
</div>

<?php include dirname(__DIR__, 1)."/templates/Javascript.php"; ?>

</body>
</html>
