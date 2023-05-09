<?php

if (!$this->session->authenticated()) {
    $this->renderOrDie($_ENV["HOME_PAGE"]);
}

$this->title = "Dashboard";
$this->menu = [
    "Workouts" => "/workouts",
    "Exercises" => "/exercises"
];

?>

<?php $this->tryRenderTemplate('htmlheader.php'); ?>

<div class="dash__body">
    <div class="dash__wrap">

        <?php $this->tryRenderTemplate('pageheader.php'); ?>

        <div id="content" class="dash__display dash__display--log">
            <div class="dash__body">
                <a class="dash__link" href="/go">
                    <div class="dash__button-start">
                        <div class="button">
                            <span class="fa fa-plus footer__icon"></span> Start New Workout
                        </div>
                    </div>
                </a>
                <div class="dash__display">
                    <div class="dash__body">
                        <?php
                        $results = \Core\Database::execute('total-workouts.sql', [
                            'user_id' => $this->session->user->id
                        ]);
                        $totalWorkouts = $results[0]['total'];
                        ?>
                        <div class="analytics__row ">
                            <span class="analytics__title">Total workouts: </span><span class="analytics__result"><?php echo $totalWorkouts ?></span>
                        </div>
                    </div>
                </div>
                <div id="log" class="log"></div>
            </div>
        </div>

    </div><!-- wrap -->

    <?php $this->tryRenderTemplate('authpagefooter.php'); ?>

    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/log.js"></script>
    <script>
        Log.init(api);
    </script>

</div><!-- body -->

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>