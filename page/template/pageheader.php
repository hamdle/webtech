<div id="menu" class="dash__display dash__display--header">
    <div class="header__body">
        <div class="header__wrap">
            <div class="header__title"><a class="link" href="<?php echo $_ENV['ORIGIN'].$_ENV['AUTH_HOME_LINK']; ?>"><?php echo $_ENV['APP_NAME']; ?></a> <span class="fa fa-right-arrow footer__icon"></span>
                <?php echo $this->title; ?>
                <span class="header__user">
                    <?php foreach ($this->menu as $title => $link) { ?>
                        <span class="header__actions">
                            <span class="header__links">
                                <a class="action" href="<?php echo $link; ?>"><?php echo $title; ?></a>
                            </span>
                        </span>
                    <?php } ?>

                    <span class="header__links">
                        <a class="link" href="/user"><?php echo $this->session->user->email; ?></a>
                    </span>
                    <span class="fa fa-user footer__icon"></span>
                    <span class="header__links">
                        <a id="logout" class="link" href="/logout">Logout</a>
                    </span>
                </span>
            </div>
            <div class="header__menu">
            </div>
        </div>
    </div>
</div>