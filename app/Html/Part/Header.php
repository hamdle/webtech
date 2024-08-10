<header id="navigation" class="p-navigation is-dark">
    <div class="p-navigation__row">
        <div class="p-navigation__banner">
            <div class="p-navigation__logo w-navigation__logo">
                <a class="p-navigation__item w-navigation__item" href="<?php echo $_ENV['ORIGIN']; ?>/home">
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
            <?php if (\App\Core\Context::get('session')->isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item ">
                        <a class="p-navigation__link" href="<?php echo $_ENV["ORIGIN"]; ?>">
                            <?php echo $_ENV["APP_NAME"]; ?>
                        </a>
                    </li>
                    <li class="p-navigation__item <?php if (\App\Core\Utils\Helper::onPage("/home")) { ?> is-selected <?php } ?>">
                        <a class="p-navigation__link" href="/home">
                            Dashboard
                        </a>
                    </li>
                    <li class="p-navigation__item <?php if (\App\Core\Utils\Helper::onPage("/takepicture")) { ?> is-selected <?php } ?>">
                        <a class="p-navigation__link" href="/takepicture">
                            Takepicture
                        </a>
                    </li>
                    <ul class="p-navigation__items">
                        <li class="p-navigation__item--dropdown-toggle <?php if (\App\Core\Utils\Helper::onPage("/workout/go") || \App\Core\Utils\Helper::onPage("/workout") || \App\Core\Utils\Helper::onPage("/workout/timer")) { ?> is-selected <?php } ?>" id="link-1">
                            <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                                Workout
                            </a>
                            <ul class="p-navigation__dropdown--right" id="account-menu" aria-hidden="true">
                                <li>
                                    <a href="/workout" class="p-navigation__dropdown-item">View</a>
                                </li>
                                <li>
                                    <a href="/workout/go" class="p-navigation__dropdown-item">New</a>
                                </li>
                                <li>
                                    <a href="/workout/timer" class="p-navigation__dropdown-item">Timer</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
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

            <?php if (\App\Core\Context::get('session')->isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item--dropdown-toggle <?php if (\App\Core\Utils\Helper::onPage("/user")) { ?> is-selected <?php } ?>" id="link-1">
                        <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                            <?php echo \App\Core\Context::get('user')->first_name." ".\App\Core\Context::get('user')->last_name; ?>
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
                    <li class="p-navigation__item <?php if (\App\Core\Utils\Helper::onPage("/login")) { ?> is-selected <?php } ?>" id="link-1">
                        <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="/login">
                            Login
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </nav>
    </div>
</header>