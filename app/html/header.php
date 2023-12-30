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
            <?php if ($this->isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item <?php if ($this->onPage("/home")) { ?> is-selected <?php } ?>">
                        <a class="p-navigation__link" href="/home">
                            Workouts
                        </a>
                    </li>
                    <li class="p-navigation__item <?php if ($this->onPage("/go")) { ?> is-selected <?php } ?>">
                        <a class="p-button p-navigation__link  has-icon" href="/go">
                            <span style="margin-right:10px;"><i id="workout-in-progress__icon" class="<?php if ($this->onPage("/go")) { ?> is-selected p-icon--spinner <?php } else { ?> p-icon--plus<?php } ?>"></i></span>
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

            <?php if ($this->isAuthenticated()) { ?>
                <ul class="p-navigation__items">
                    <li class="p-navigation__item--dropdown-toggle <?php if ($this->onPage("/user")) { ?> is-selected <?php } ?>" id="link-1">
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
                    <li class="p-navigation__item  <?php if ($this->onPage("/login")) { ?> is-selected <?php } ?>" id="link-1">
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