<script src="<?php echo $_ENV['ORIGIN']; ?>/js/log.js"></script>
<script>
    Log.init(api,
        document.getElementById("prev"),
        document.getElementById("next"),
        document.getElementById("page-display"),
        <?php echo \App\Core\Context::get('total-workouts') ?>,
        <?php echo \App\Core\Database\Database::config("pagination_default", \App\Core\Context::get('user')->fields["id"]) ?>
    );
</script>