<footer class="footer__login">
    <div class="footer__wrap--left">
        <a href="<?php echo $_ENV['WORKOUT_DEV_LINK']; ?>" class="link" target="_blank">Workout.dev</a>
        <span class="fa fa-info footer__icon"></span> version
        <b><?php echo $_ENV['VERSION']; ?></b>
        <span class="fa fa-dash footer__icon"></span>
        <span class=""><span class="fa fa-connection footer__icon"></span>
            <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
        </span>
    </div>
</footer>

<script src="/../js/component/logout.js"></script>
<script>
    let api = "<?php echo $_ENV['SITE_URL']; ?>";
    let site = "<?php echo $_ENV['ORIGIN']; ?>" + "/";
    Logout.init(api, site, document.getElementById("logout"));
</script>