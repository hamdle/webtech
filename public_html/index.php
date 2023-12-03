<?php

include dirname(__DIR__,1) . "/App.php";

$App = new App();

//$App->RedirectAuthenticated("home.php");

$App->title = "Home";

$App->RenderHtml('open.php');
$App->RenderHtml('header.php');

?>

<main id="main-content" class="">
    <section class="p-strip">
        <div class="row">
            <div class="col-6">
                <div class="form-box p-card selected-login">
                    <h1 class="p-heading--four title login-title">Landing Page</h1>
                    <hr>
                    <form id="loginForm" class="login__form">
                        <label class="login__title">User email:</label>
                        <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Email" name="email" />
                        <label class="login__title">Password:</label>
                        <input class="input login__input" autocapitalize="off" autocorrect="off" type="password" placeholder="Password" name="password" />
                        <button id="login__button" class="button login__button" type="submit"><span class="fa fa-lock footer__icon login-button__icon"></span> Login</button>
                    </form>
                </div>
            </div>
            <aside class="col-6">
                <div class="p-table-of-contents">
                    <div class="related-information">
                        <p>
                            <b>Welcome to <?php echo $_ENV['APP_NAME']; ?>!</b> Join today to build your perfect calisthenics workout routine. Design a workout that fit you using our library of exercises or create your own.
                        </p>
                        <p>
                            Want to know more about <?php echo $_ENV['APP_NAME']; ?> features?<br>
                            <a href="/">Read More ›</a>
                        </p>
                    </div>

                </div>
            </aside>
        </div>
    </section>
</main>

<?php $App->RenderHtml("footer.php"); ?>

<script>
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

<?php $App->RenderHtml('close.php'); ?>
