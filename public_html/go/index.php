<?php

use app\Core;
use api\Core\Database\Database;

require_once dirname(__DIR__, 2) . "/autoload.php";

$App = new Core("Go");
$get = isset($_GET["el"]) ? $_GET["el"] : null;
$el = $get ? explode(",", $get) : null;
$App->renderHtml(Core::HTML_OPEN);
$App->renderHtml(Core::HTML_HEADER);

?>

<div id="main-content" class="l-site">
    <div class="p-stripe is-shallow">


        <div class="row dash__display dash__display--workout">
            <div class="dash__body">
                <div id="timer" class="timer"></div>
                <div class="countdown__wrap">
                    <div class="countdown__base">
                        <div class="countdown__label">cooldown</div>
                        <div id="countdown" class="countdown">00:00</div>
                    </div>
                </div>
                <div id="inputdisplay" class="inputdisplay"></div>
                <div id="instructions" class="instructions">
                    <span class="start-button__wrap">
                        <button id="start__button" class="p-button has-icon"><span class="fa fa-clock exercise__icon"></span>Start</button>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="u-align--center">
                <div class="opt__title">
                    <h3>Exercises</h3>
                </div>
                <span>
                    <button id="exercise__button--add" class="p-button">Add</button>
                </span>
                <span>
                    <button id="exercise__button--remove" class="p-button">Remove</button>
                </span>
                <ol id="exercise__list" class="opt__exercise">
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="u-align--center">
                <span>
                    <button href="#" id="discard" class="p-button--negative">Discard</button>
                </span>
            </div>

        </div>

    </div>
</div>

<?php $App->renderHtml(Core::HTML_FOOTER); ?>

<script src="<?php echo $_ENV['ORIGIN']; ?>/js/workout.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/routinebuilder.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/startbutton.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/utilities.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/timer.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/countdown.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/inputdisplay.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/instructions.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/jumptoinput.js"></script>
<script>
    function onStart(loadNext = true) {
        Startbutton.disable();
        Instructions.hide();
        Workout.create();
        InputDisplay.init(document.getElementById('inputdisplay'), <?php echo Database::config("set_rest_default", $App->user->fields["id"]) ?>);
        if (loadNext) {
            InputDisplay.next();
        }
        Timer.start();
        Countdown.start(<?php echo Database::config("set_rest_default") ?>);
        // Warn user before exiting workout
        // window.onbeforeunload = function () {
        //     return "Quit workout?";
        // };
    }

    Workout.init();
    Workout.tab(
        document.getElementById("workout-in-progress"),
        document.getElementById("workout-in-progress__icon"),
    );
    RoutineBuilder.init(document.getElementById('exercise__list'), JSON.parse('<?php echo json_encode($el) ?>'));

    Timer.init(document.getElementById('timer'));
    var timer = document.getElementById('timer')
    timer.addEventListener('click', function () {
        Countdown.start(<?php echo Database::config("rep_rest_default", $App->user->fields["id"]) ?>);
    });

    Countdown.init(document.getElementById('countdown'));
    Instructions.init(document.getElementById('instructions'));
    JumpToInput.init(document.getElementById('timer'), 'inputdisplay');


    var inProgress = localStorage.getItem("workout.exerciseInProgress");
    var startButtonElement = document.getElementById('start__button')
    if (inProgress) {
        Startbutton.init(startButtonElement, onStart, true);
    } else {
        Startbutton.init(startButtonElement, onStart);
    }
</script>

<script>
    var discard = document.getElementById("discard");
    discard.addEventListener("click", function (event) {
        Workout.discard();
        location.reload();
    });
</script>

<?php $App->renderHtml(Core::HTML_CLOSE); ?>