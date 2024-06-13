<?php

use \Api\Core\Utils\Helper;

$name = 'Workout';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $name; ?> - <?php echo $_ENV['APP_NAME']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/x-icon" href="<?php echo $_ENV['ORIGIN']; ?>/img/favicon.ico">
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/vanilla.css" rel="stylesheet" type="text/css">
    <?php if (Helper::onPage("/go")) { ?>
        <link href="<?php echo $_ENV['ORIGIN']; ?>/css/go.css" rel="stylesheet" type="text/css">
    <?php } ?>
</head>
<body>


<header id="navigation" class="p-navigation is-dark">
    <div class="p-navigation__row">
        <div class="p-navigation__banner">
            <div class="p-navigation__logo w-navigation__logo">
                <a class="p-navigation__item w-navigation__item" href="<?php echo $_ENV['ORIGIN']; ?>">
                    <img class="p-navigation__logo-icon" src="<?php echo $_ENV['ORIGIN']; ?>/img/workout-logo-graybox.svg" alt="Workout.dev">
                </a>
            </div>
            <a href="#navigation" class="p-navigation__toggle--open" title="menu">Menu</a>
            <a href="#navigation-closed" class="p-navigation__toggle--close" title="close menu">Close menu</a>
        </div>
        <nav class="p-navigation__nav" aria-label="">
            <span class="u-off-screen">
                <a href="#main-content">Jump to main content</a>
            </span>
            <?php if (Helper::isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item <?php if (Helper::onPage("/home")) { ?> is-selected <?php } ?>">
                        <a class="p-navigation__link" href="/home">
                            Workouts
                        </a>
                    </li>
                    <li class="p-navigation__item <?php if (Helper::onPage("/go")) { ?> is-selected <?php } ?>">
                        <a class="p-button p-navigation__link  has-icon" href="/go">
                            <span style="margin-right:10px;"><i id="workout-in-progress__icon" class="<?php if (Helper::onPage("/go")) { ?> is-selected p-icon--spinner <?php } else { ?> p-icon--plus<?php } ?>"></i></span>
                            <span id="workout-in-progress">New</span>
                        </a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item ">
                        <a class="p-navigation__link" href="/">
                            <?php echo $_ENV["APP_NAME"]; ?>
                        </a>
                    </li>
                </ul>
            <?php } ?>

            <?php if (Helper::isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item--dropdown-toggle <?php if (Helper::onPage("/user")) { ?> is-selected <?php } ?>" id="link-1">
                        <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                            <?php echo $this->user->first_name." ".$this->user->last_name; ?>
                        </a>
                        <ul class="p-navigation__dropdown--right" id="account-menu" aria-hidden="true">
                            <li>
                                <a href="/user" class="p-navigation__dropdown-item">Settings</a>
                            </li>
                            <li>
                                <a id="logout" href="/logout" class="p-navigation__dropdown-item">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item  <?php if (Helper::onPage("/login")) { ?> is-selected <?php } ?>" id="link-1">
                        <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                            Login
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </nav>
    </div>
    <script>
        var $element = document.getElementById("workout-in-progress");
        var $icon = document.getElementById("workout-in-progress__icon")
        var $value = localStorage.getItem("workout.exerciseInProgress");
        if ($value) {
            $element.textContent = $value;
            $icon.classList.add("p-icon--spinner");
            $icon.classList.add("u-animation--spin");
        }
    </script>
</header>


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


<footer class="p-strip--light p-sticky-footer" id="footer">
    <div class="row">
        <div class="col-9">
            <h3><span style="font-weight: 800"><?php echo $_ENV['APP_NAME']; ?></span></h3><br>
            <?php if (Helper::isAuthenticated()) {?>
                <dl>
                    <dd>
                        <span class=""><span style="margin-right:3px;" class="fa fa-connection footer__icon"></span>
                        <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
                        </span>
                    </dd>
                    <dd>
                        <span style="margin-right:3px;" class="fa fa-info footer__icon"></span>Release: <a href="https://github.com/hamdle/workout.dev/releases/tag/v2.0" target="_blank"> v<b><?php echo $_ENV['VERSION']; ?></b></a>

                    </dd>
                </dl>
            <?php } ?>
        </div>
        <div class="col-3">
            <p>
                <?php if (!Helper::onPage("/login")) { ?>
                    <a class="p-link--soft" href="#">Back to top<i class="p-icon--top"></i> <span class="fa fa-arrow-up footer__icon"></span></a>
                <?php } ?>
            </p>
        </div>
    </div>
</footer>

<script>
    function toggleDropdown(toggle, open) {
        var parentElement = toggle.parentNode;
        var dropdown = document.getElementById(toggle.getAttribute('aria-controls'));
        dropdown.setAttribute('aria-hidden', !open);

        if (open) {
            parentElement.classList.add('is-active');
        } else {
            parentElement.classList.remove('is-active');
        }
    }

    function closeAllDropdowns(toggles) {
        toggles.forEach(function (toggle) {
            toggleDropdown(toggle, false);
        });
    }

    function handleClickOutside(toggles, containerClass) {
        document.addEventListener('click', function (event) {
            var target = event.target;

            if (target.closest) {
                if (!target.closest(containerClass)) {
                    closeAllDropdowns(toggles);
                }
            }
        });
    }

    function initNavDropdowns(containerClass) {
        var toggles = [].slice.call(document.querySelectorAll(containerClass + ' [aria-controls]'));

        handleClickOutside(toggles, containerClass);

        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();

                const shouldOpen = !toggle.parentNode.classList.contains('is-active');
                closeAllDropdowns(toggles);
                toggleDropdown(toggle, shouldOpen);
            });
        });
    }
    initNavDropdowns('.p-navigation__item--dropdown-toggle')
</script>

<script src="<?php echo $_ENV['ORIGIN']; ?>/js/logout.js"></script>
<script>
    let api = "<?php echo $_ENV['API_URL']; ?>";
    let site = "<?php echo $_ENV['ORIGIN']; ?>" + "/";
    <?php if (Helper::isAuthenticated()) { ?>
    Logout.init(api, site, document.getElementById("logout"));
    <?php } ?>
</script>


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


</body>
</html>