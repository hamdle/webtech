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