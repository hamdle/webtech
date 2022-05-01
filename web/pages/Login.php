<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Workout.dev</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php //include __DIR__.'/template.html'; ?>

    <div class="login__body">
        <div class="login__wrap">
            <div class="login-form__wrap">
                <form id="loginForm" class="login__form">
                    <h1 class="login__header">Workout.dev</h1>
                    <span class="login__desc">A calisthenics workout app</span>
                    <label class="login__title">Login</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Email" name="email" />
                    <label class="login__title">Password</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="password" placeholder="Password" name="password" />
                    <button class="button login__button" type="submit">Login</button>
                </form>
            </div>
        </div>
        <footer class="footer__login">
            <a href="https://github.com/hamdle/workout-web-app" target="_blank">Workout.dev</a> v<span id="version"></span> <span class="environment"><span class="fa fa-running footer__icon"></span><?php echo $_ENV['ENVIRONMENT']; ?></span>
        </footer>
    </div>

    <script>
        let api = "http://workout.local/api/";
        let site = "http://workout.local/";
    </script>
    <script src="/../js/components/version.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/components/verifyuser.js"></script>
    <script>
        Version.init();
        window.addEventListener("load", function() {
            // Send login form data to Api and redirect on success
            function sendData() {
                const $xhr = new XMLHttpRequest();
                const formData = new FormData(form);

                // TODO: Clean this up. Don't need both of thses.
                $xhr.addEventListener('load', function(event) {
                    //console.log(event.target.responseText);
                    //window.location = site + 'go';
                });
                $xhr.onreadystatechange = function() {
                    if ($xhr.readyState == XMLHttpRequest.DONE) {
                        if (this.status == 201) {
                            window.location = site + 'home';
                        } else {
                            console.log('Login failed. Response code: '+this.status);
                        }
                    }
                }
                $xhr.addEventListener('error', function(event) {
                    console.log('An error occured while logging in.');
                });
                $xhr.open("POST", api + 'login');
                // Specifying a header here could cause the POST data to be send
                // incorrectly, don't set it explicitly and let the broswer generate
                // the correct one automatically
                $xhr.send(formData);
            }

            let form = document.getElementById('loginForm');
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                sendData();
            });
        });
    </script>
</body>
</html>
