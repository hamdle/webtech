<?php

use app\Core;

include dirname(__DIR__, 2) . "/app/Core.php";

$App = new Core();

$App->IsAuthenticated();

$App->title = "Dashboard";

$App->RenderHtml('open.php');
$App->RenderHtml('header.php');

?>

<div id="main-content" class="l-site">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--3">
                Workouts
            </h1>
        </div>
    </section>
    <div class="p-stripe is-shallow">
        <div class="row">
            <div class="u-clearfix">
                <div class="u-float-left">
                    <a class="dash__link" href="/go">
                        <button class="p-tooltip--top-center has-icon" aria-describedby="btn-new-workout">
                            <i class="p-icon--spinner"></i>
                            New Workout
                            <span class="p-tooltip__message" role="tooltip" id="btn-new-workout"><span class="w-blink__item">Press Start</span></span>
                        </button>
                        <button class="p-button--positive p-tooltip--top-center has-icon" aria-describedby="btm-cntr">
                            <i class="p-icon--success"></i>
                            16
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >Completed</span>
                        </button>
                    </a>
                </div>
                <div class="u-float-right">
                    <div class="">
                        <?php
                        $results = \Core\Database::execute('total-workouts.sql', [
                            'user_id' => $App->User->id
                        ]);
                        $totalWorkouts = $results[0]['total'];
                        ?>
                        <div class="analytics__row ">
                            <span class="analytics__title">
                                Show: <b>ALL</b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="p-card">
                <div id="log" class="log"></div>
            </div>
        </div>
    </div>
</div>

<?php $App->RenderHtml('footer.php'); ?>

<script src="<?php echo $_ENV['ORIGIN']; ?>/js/log.js"></script>
<script>
    Log.init(api);
</script>

<?php $App->RenderHtml('close.php'); ?>
