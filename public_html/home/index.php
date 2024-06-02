<?php

use App\Core;
use Api\Core\Database\Database;

require_once dirname(__DIR__, 2) . "/autoload.php";

$App = new Core("Home");
$App->renderHtml([Core::HTML_OPEN, Core::HTML_HEADER]);

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
                            <i class="p-icon--plus"></i>
                            New Workout
                        </button>
                        <button class="p-button--positive p-tooltip--top-center has-icon" aria-describedby="btm-cntr">
                            <i class="p-icon--success"></i>
                            <?php
                            $results = Database::execute('total-workouts.sql', [
                                'user_id' => $App->user->fields["id"]
                            ]);
                            $totalWorkouts = $results[0]['total'];
                            echo $totalWorkouts;
                            ?>
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >Completed Workouts</span>
                        </button>
                    </a>
                </div>
                <div class="u-float-right">
                    <nav class="p-pagination" aria-label="Pagination">
                        <ol class="p-pagination__items">
                            <li class="p-pagination__item">
                                <span id="page-display" class="p-pagination__display"></span>
                            </li>
                            <li class="p-pagination__item">
                                <a id="prev" class="p-pagination__link--previous" href="#" title="Previous page"><i class="p-icon--chevron-down"></i></a>
                            </li>
                            <li class="p-pagination__item">
                                <a id="next" class="p-pagination__link--next" href="#" title="Next page"><i class="p-icon--chevron-down"></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="log" class="log"></div>
        </div>
    </div>
</div>

<?php $App->renderHtml(Core::HTML_FOOTER); ?>

<script src="<?php echo $_ENV['ORIGIN']; ?>/js/log.js"></script>
<script>
    Log.init(api,
        document.getElementById("prev"),
        document.getElementById("next"),
        document.getElementById("page-display"),
        <?php echo $totalWorkouts ?>,
        <?php echo Database::config("pagination_default", $App->user->fields["id"]) ?>
    );
</script>

<?php $App->renderHtml(Core::HTML_CLOSE); ?>