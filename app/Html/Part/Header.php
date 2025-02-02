<header id="navigation" class="p-navigation is-dark">
    <div class="p-navigation__row">
        <div class="p-navigation__banner">
            <div class="p-navigation__logo w-navigation__logo">
                <a class="p-navigation__item w-navigation__item w-navigation__item--<?php echo $_ENV['LOGO'] ?? 'name'; ?>" href="<?php echo $_ENV['ORIGIN']; ?>">
                    <img class="p-navigation__logo-icon" src="<?php echo $_ENV['ORIGIN']; ?>/img/ejmtech-<?php echo $_ENV['LOGO'] ?? 'name'; ?>-logo.png" alt="ejmtech.net logo">
                </a>
            </div>
            <a href="#navigation" class="p-navigation__toggle--open" title="menu">Menu</a>
            <a href="#navigation-closed" class="p-navigation__toggle--close" title="close menu">Close menu</a>
        </div>
        <nav class="p-navigation__nav" aria-label="">
            <span class="u-off-screen">
                <a href="#main-content">Jump to main content</a>
            </span>

            <ul class="p-navigation__items">

                <li class="p-navigation__item  <?php if (\App\Core\Utils\Helper::onPage("/services")) { ?> is-selected <?php } ?>">
                    <a class="p-navigation__link" href="/services">
                        Services
                    </a>
                </li>
                <li class="p-navigation__item  <?php if (\App\Core\Utils\Helper::onPage("/about")) { ?> is-selected <?php } ?>">
                    <a class="p-navigation__link" href="/about">
                        About
                    </a>
                </li>
                <li class="p-navigation__item  <?php if (\App\Core\Utils\Helper::onPage("/contact")) { ?> is-selected <?php } ?>">
                    <a class="p-navigation__link" href="/contact">
                        Contact
                    </a>
                </li>
            </ul>

            <?php if (\App\Core\Context::get('session')->isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item--dropdown-toggle <?php if (\App\Core\Utils\Helper::onPage("/user")) { ?> is-selected <?php } ?>" id="link-1">
                        <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                            <?php echo \App\Core\Context::get('user')->first_name." ".\App\Core\Context::get('user')->last_name; ?>
                        </a>
                        <ul class="p-navigation__dropdown--right" id="account-menu" aria-hidden="true">
                            <li>
                                <a href="/home" class="p-navigation__dropdown-item">Dashboard</a>
                            </li>
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