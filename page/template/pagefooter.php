<footer class="footer__login">
    <div class="footer__wrap--bottom">
        <a href="<?php echo $_ENV['WORKOUT_DEV_LINK']; ?>" class="link" target="_blank"><?php echo $_ENV['APP_NAME']; ?></a>
        <span class="fa fa-info footer__icon"></span> version
        <b><?php echo $_ENV['VERSION']; ?></b>
        <span class="fa fa-dash footer__icon"></span>
        <span><span class="fa fa-connection footer__icon"></span>
            <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
        </span>
    </div>
</footer>