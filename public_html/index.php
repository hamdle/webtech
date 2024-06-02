<?php

use App\Core;

require_once dirname(__DIR__, 1) . "/autoload.php";

$App = new Core("Login");
$App->renderHtml([Core::HTML_OPEN, Core::HTML_HEADER]);

?>

<main id="main-content" class="">
    <section class="p-strip">
        <div class="row">
            <div class="col-6">
                <div class="p-notification--negative u-hide" id="notification">
                    <div class="p-notification__content">
                        <h5 class="p-notification__title">Login Failed</h5>
                        <p class="p-notification__message">Please check your user and password and try again.</p>
                        <button class="p-notification__close" aria-controls="notification">Close</button>
                    </div>
                </div>
                <div class="form-box p-card selected-login">
                    <h1 class="p-heading--four title login-title">Login</h1>
                    <hr>
                    <form id="loginForm" class="login__form">
                        <label class="login__title">User email:</label>
                        <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Email" name="email" />
                        <label class="login__title">Password:</label>
                        <input class="input login__input" autocapitalize="off" autocorrect="off" type="password" placeholder="Password" name="password" />
                        <input type="hidden" name="method" value="Auth.login">
                        <button id="login__button" class="button login__button" type="submit"><span class="fa fa-lock footer__icon login-button__icon"></span> Login</button>
                    </form>
                </div>
            </div>
            <aside class="col-6">
                <div class="p-table-of-contents">
                    <div class="related-information">
                        <p>
                            <b>Welcome to <?php echo $_ENV['APP_NAME']; ?>!</b> Join today to track calisthenics and home gym workouts in real time. Build and tweak exercies to perfection. Track workout metrics powered by A.I.
                        </p>
                        <p>
                            Want to know more about <?php echo $_ENV['APP_NAME']; ?>?<br>
                            <a href="/">Read More ›</a>
                        </p>
                    </div>

                </div>
            </aside>
        </div>
    </section>
</main>

<?php $App->renderHtml(Core::HTML_FOOTER); ?>

<script>
    window.addEventListener("load", function()
    {
        function sendData()
        {
            const $xhr = new XMLHttpRequest();
            const formData = new FormData(form);

            $xhr.addEventListener('load', function(event)
            {
                const response = JSON.parse(event.target.responseText);
                if (response.ok === 'false' || response.warning === 'login failed')
                {
                    let notification = document.getElementById('notification');
                    if (notification) {
                        notification.classList.remove('u-hide');
                    }
                }
            });
            $xhr.addEventListener('readystatechange', function(event)
            {
                if ($xhr.readyState == XMLHttpRequest.DONE)
                {
                    const response = JSON.parse(event.target.responseText);
                    if (response.ok === 'false' || response.hasOwnProperty('warning') || response.hasOwnProperty('error')) {
                        return;
                    }
                    if (response.ok === 'true') {
                        window.location = site + 'home';
                    }
                }
            });
            $xhr.addEventListener('error', function(event)
            {
                console.log('An error occurred while logging in.');
            });
            $xhr.open("POST", api);
            // Specifying a header here could cause the POST data to be sent
            // incorrectly, don't set it explicitly and let the browser generate
            // the correct one automatically
            $xhr.send(formData);
        }

        let form = document.getElementById('loginForm');
        form.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData();
        });
    });
</script>

<script>
    var closeButtons = document.querySelectorAll('.p-notification__close');

    function setupCloseButton(closeButton) {
        closeButton.addEventListener('click', function(event) {
            var target = event.target.getAttribute('aria-controls');
            var notification = document.getElementById(target);

            if (notification)
            {
                notification.classList.add('u-hide');
            }
        });
    }

    for (var i = 0, l = closeButtons.length; i < l; i++)
    {
        setupCloseButton(closeButtons[i]);
    }
</script>

<?php $App->renderHtml(Core::HTML_CLOSE); ?>