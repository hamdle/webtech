<script src="<?php echo $_ENV['ORIGIN']; ?>/js/workout.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/routinebuilder.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/startbutton.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/utilities.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/timer.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/countdown.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/inputdisplay.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/instructions.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/jumptoinput.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/screenwake.js"></script>
<script src="<?php echo $_ENV['ORIGIN']; ?>/js/gamepad.js"></script>

<script>
    function onStart(loadNext = true) {
        Startbutton.disable();
        Instructions.hide();
        Workout.create();
        InputDisplay.init(document.getElementById('inputdisplay'), <?php echo \App\Core\Database\Database::config("set_rest_default",  \App\Core\Context::get('user')->fields["id"]) ?>);
        if (loadNext) {
            InputDisplay.next();
        }
        Timer.start();
        Countdown.start(<?php echo \App\Core\Database\Database::config("set_rest_default", \App\Core\Context::get('user')->fields["id"]) ?>);
        // Warn user before exiting workout
        // window.onbeforeunload = function () {
        //     return "Quit workout?";
        // };
        Gamepad.start();
    }

    Workout.init();
    Workout.tab(
        document.getElementById("workout-in-progress"),
        document.getElementById("workout-in-progress__icon"),
    );
    RoutineBuilder.init(document.getElementById('exercise__list'), JSON.parse('<?php echo json_encode(\App\Core\Context::get('exerciseList')) ?>'));

    Timer.init(document.getElementById('timer'));
    var timer = document.getElementById('timer')
    timer.addEventListener('click', function () {
        Countdown.start(<?php echo \App\Core\Database\Database::config("rep_rest_default", \App\Core\Context::get('user')->fields["id"]) ?>);
    });

    Countdown.init(
        document.getElementById('countdown'),
        <?php echo \App\Core\Database\Database::config("play_timer_sound", \App\Core\Context::get('user')->fields["id"]) ?>
    );
    Instructions.init(document.getElementById('instructions'));
    JumpToInput.init(document.getElementById('timer'), 'inputdisplay');


    var inProgress = localStorage.getItem("workout.exerciseInProgress");
    var startButtonElement = document.getElementById('start__button')
    if (inProgress) {
        Startbutton.init(startButtonElement, onStart, true);
    } else {
        Startbutton.init(startButtonElement, onStart);
    }

    ScreenWake.init(document.getElementById('screen-wake'));
    Gamepad.init();
</script>

<script>
    var discard = document.getElementById("discard");
    discard.addEventListener("click", function (event) {
        Workout.discard();
        location.reload();
    });
</script>