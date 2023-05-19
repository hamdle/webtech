<?php

if (!$this->session->authenticated()) {
    $this->renderOrDie($_ENV["HOME_PAGE"]);
}

$this->title = "Go";
$this->menu = [
];

?>
<?php $this->tryRenderTemplate('htmlheader.php'); ?>

<div class="dash__body">
    <div class="dash__wrap">

        <?php $this->tryRenderTemplate('pageheader.php'); ?>

        <div id="content" class="dash__display dash__display--routine">
            <div class="dash__body">
                <div class="opt__title">
                    <span>Next exercise</span>
                </div>
                <!-- Put custom modules here. -->
                <span class="opt-title__extra">
                    <a id="exercise__button--add" class="button button__spacing--right">Add</a>
                </span>
                <span><a id="exercise__button--remove" class="link">Remove</a></span>

                <ul id="exercise__list" class="opt__exercise">
                </ul>
            </div>
        </div>

        <div class="dash__display dash__display--workout">
            <div class="dash__body">

                <!-- Put custom modules here. -->
                <div id="timer" class="timer"></div>
                <div class="countdown__wrap">
                    <div class="countdown__base">
                        <div class="countdown__label">cooldown</div>
                        <div id="countdown" class="countdown"></div>
                    </div>
                </div>
                <div id="inputdisplay" class="inputdisplay"></div>
                <div id="instructions" class="instructions">
                    <p>
                        <span class="start-button__wrap">

                            <a id="start__button" class="button"><span class="fa fa-clock exercise__icon"></span>Start</a>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="dash__display dash__display--log hide">
            <div class="dash__body">
                <div class="opt__title">
                    <span>Log</span>
                </div>
                <!-- Put custom modules here. -->
                <div id="log" class="log"></div>
            </div>
        </div>
    </div><!-- wrap -->

    <?php $this->tryRenderTemplate('authpagefooter.php'); ?>

    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/workout.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/routinebuilder.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/startbutton.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/utilities.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/timer.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/countdown.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/inputdisplay.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/instructions.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/verifyuser.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/log.js"></script>
    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/component/jumptoinput.js"></script>
    <script>
        function onStart() {
            Startbutton.disable();
            Instructions.hide();
            Workout.create();
            InputDisplay.init(document.getElementById('inputdisplay'));
            InputDisplay.next();
            Timer.start();
            // TODO: Replace this magic number with value from user settings.
            Countdown.start(120);
            window.onbeforeunload = function () {
                return "Quit workout?";
            };
        }

        Workout.init();
        RoutineBuilder.init(document.getElementById('exercise__list'));
        Startbutton.init(onStart);

        Timer.init(document.getElementById('timer'));
        var timer = document.getElementById('timer')
        timer.addEventListener('click', function () {
            Countdown.start(60);
        });

        Countdown.init(document.getElementById('countdown'));
        Instructions.init(document.getElementById('instructions'));
        Log.init(app);
        JumpToInput.init(document.getElementById('timer'), 'inputdisplay');
    </script>

</div><!-- body -->

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>
