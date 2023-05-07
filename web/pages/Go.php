<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Go - Workout app.</title>
    <link href="/../css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="dash__body">
    <div class="dash__wrap">
        <div class="dash__display dash__display--header">
            <div class="header__body">
                <div class="header__wrap">
                    <?php
                        global $app;
                        $session = $app::getObject('session');
                        $user = $session->user;
                    ?>
                    <div class="header__title"><a class="link" href="/home">Workout.dev</a> <span class="fa fa-right-arrow footer__icon"></span>
                        Workout
                        <span class="header__user">
                             <span class="fa fa-user footer__icon"></span>
                            <span class="header__links">
                                <a class="link" href="/user/"><?php echo $user->email; ?></a>
                            </span>
                        </span>
                    </div>
                    <div class="header__menu">
                    </div>
                </div>
            </div>
        </div>

        <div class="dash__display dash__display--routine">
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
        <footer class="footer__login">
            <div class="footer__wrap--bottom">
                <a href="https://github.com/hamdle/workout-web-app" class="link" target="_blank">Workout.dev</a>
                <span class="fa fa-info footer__icon"></span> version
                <b><?php echo $_ENV['VERSION']; ?></b>
                <span class="fa fa-dash footer__icon"></span>
                <span class=""><span class="fa fa-connection footer__icon"></span>
                        <b><?php echo $_ENV['ENVIRONMENT']; ?></b>
                    </span>
            </div>
        </footer>
    </div>

    <?php include dirname(__DIR__, 1)."/templates/Javascript.php"; ?>

    <script src="/../js/components/workout.js"></script>
    <script src="/../js/components/routinebuilder.js"></script>
    <script src="/../js/components/startbutton.js"></script>
    <script src="/../js/components/utilities.js"></script>
    <script src="/../js/components/timer.js"></script>
    <script src="/../js/components/countdown.js"></script>
    <script src="/../js/components/inputdisplay.js"></script>
    <script src="/../js/components/instructions.js"></script>
    <script src="/../js/components/verifyuser.js"></script>
    <script src="/../js/components/log.js"></script>
    <script src="/../js/components/jumptoinput.js"></script>
    <script>
        function startHandler() {
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
        Startbutton.init(startHandler);
        Timer.init(document.getElementById('timer'));
        Countdown.init(document.getElementById('countdown'));
        Instructions.init(document.getElementById('instructions'));
        Log.init();
        JumpToInput.init(document.getElementById('timer'), 'inputdisplay');

        var timer = document.getElementById('timer')
        timer.addEventListener('click', function () {
            Countdown.start(60);
        });

    </script>
</div>
</body>
</html>
