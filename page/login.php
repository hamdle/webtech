<?php

$this->title = "Login";

?>

<?php $this->tryRenderTemplate('htmlheader.php'); ?>

    <div class="login__body">
        <div class="login__wrap">
            <div class="login-form__wrap">
                <form id="loginForm" class="login__form">
                    <h1 class="login__header"><?php echo $_ENV['APP_NAME']; ?></h1>
                    <span class="login__desc">exercise <span class="fa fa-running footer__icon"></span> analyze</span>
                    <label class="login__title">Login</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Email" name="email" />
                    <label class="login__title">Password</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="password" placeholder="Password" name="password" />
                    <button id="login__button" class="button login__button" type="submit"><span class="fa fa-lock footer__icon login-button__icon"></span> Login</button>
                </form>
            </div>
        </div><!-- wrap -->

        <?php $this->tryRenderTemplate('pagefooter.php'); ?>

    </div><!-- body -->

    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/verifyuser.js"></script>
    <script>
        let api = "<?php echo $_ENV['SITE_URL']; ?>";
        let site = "<?php echo $_ENV['ORIGIN']; ?>" + "/";
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

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>
