<header id="navigation" class="p-navigation is-dark">
    <div class="p-navigation__row">
        <div class="p-navigation__banner">
            <div class="p-navigation__logo">
                <a class="p-navigation__item" href="<?php echo $_ENV['ORIGIN']; ?>">
                    <img class="p-navigation__logo-icon" src="<?php echo $_ENV['ORIGIN']; ?>/img/workout-logo-graybox.svg" alt="Workout.dev">
                </a>
            </div>
            <a href="#navigation" class="p-navigation__toggle--open" title="menu">Menu</a>
            <a href="#navigation-closed" class="p-navigation__toggle--close" title="close menu">Close menu</a>
        </div>
        <nav class="p-navigation__nav" aria-label="Example main">
      <span class="u-off-screen">
        <a href="#main-content">Jump to main content</a>
      </span>
            <ul class="p-navigation__items">
                <li class="p-navigation__item">
                    <a class="p-navigation__link" href="/home">
                        Dashboard
                    </a>
                </li>
                <li class="p-navigation__item">
                    <a class="p-navigation__link" href="/build">
                        Build
                    </a>
                </li>
                <li class="p-navigation__item">
                    <button class="p-button p-navigation__link  has-icon"><i class="p-icon--plus"></i><span>Workout</span></button>
                </li>
            </ul>

            <ul class="p-navigation__items">
                <li class="p-navigation__item--dropdown-toggle" id="link-1">
                    <a class="p-navigation__link" aria-controls="account-menu" aria-expanded="false" href="#">
                        <?php echo $this->session->user->first_name." ".$this->session->user->last_name; ?>
                    </a>
                    <ul class="p-navigation__dropdown--right" id="account-menu" aria-hidden="true">
                        <li>
                            <a href="/user" class="p-navigation__dropdown-item">Settings</a>
                        </li>
                        <li>
                            <a href="/logout" class="p-navigation__dropdown-item">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>