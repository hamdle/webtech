<footer class="p-strip--light p-sticky-footer" id="footer">
    <div class="row">
        <div class="col-9">
            <h3><span style="font-weight: 800"><?php echo $_ENV['APP_NAME']; ?></span></h3><br>
            <?php if ($this->isAuthenticated()) {?>
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
                <?php if (!$this->onPage("/login")) { ?>
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
    <?php if ($this->isAuthenticated()) { ?>
    Logout.init(api, site, document.getElementById("logout"));
    <?php } ?>
</script>