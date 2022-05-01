<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Go - Workout app.</title>
    <link href="/public_html/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php //include __DIR__ . '/template.html'; ?>

<div class="dash__wrap">

    <div class="dash__display dash__display--header">
        <div class="header__body">
            Version <span id="version"></span>
        </div>
    </div>

    <div class="dash__display dash__display--routine">
        <div class="dash__body">
            <div class="opt__title">
                <span>Routine</span>
            </div>
            <!-- Put custom modules here. -->
            <span class="opt-title__extra">
                <a id="exercise__button--add" class="button button__spacing--right">Add</a>
                <a id="exercise__button--remove" class="button">Remove</a>
            </span>
            <ul id="exercise__list" class="opt__exercise">
            </ul>
        </div>
    </div>

    <div class="dash__display dash__display--workout">
        <div class="dash__body">
            <div class="opt__title">
                <span>Workout</span>
            </div>
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
                    Build a routine and hit
                    <span class="start-button__wrap">
                        <a id="start__button" class="button">Start Workout</a>
                    </span>
                    to begin.
                </p>
            </div>
        </div>
    </div>
    <div class="dash__display dash__display--log">
        <div class="dash__body">
            <div class="opt__title">
                <span>Log</span>
            </div>
            <!-- Put custom modules here. -->
            <div id="log" class="log"></div>
        </div>
    </div>
</div>


<script src="/public_html/js/components/workout.js"></script>
<script src="/public_html/js/components/routinebuilder.js"></script>
<script src="/public_html/js/components/startbutton.js"></script>
<script src="/public_html/js/components/utilities.js"></script>
<script src="/public_html/js/components/timer.js"></script>
<script src="/public_html/js/components/countdown.js"></script>
<script src="/public_html/js/components/inputdisplay.js"></script>
<script src="/public_html/js/components/instructions.js"></script>
<script src="/public_html/js/components/verifyuser.js"></script>
<script src="/public_html/js/components/version.js"></script>
<script src="/public_html/js/components/log.js"></script>
<script>
    // go/script.js
    //
    //
    // Track a workout.

    let api = "http://workout.local/api/";

    VerifyUser.onSuccess(function() {
        // Event handlers
        function startHandler() {
            Startbutton.disable();
            Instructions.hide();
            Workout.create();
            InputDisplay.init(document.getElementById('inputdisplay'));
            InputDisplay.next();
            Timer.start();
            // TODO: Replace this magic number with value from user settings.
            Countdown.start(120);
        }

        Workout.init();
        RoutineBuilder.init(document.getElementById('exercise__list'));
        Startbutton.init(startHandler);
        Timer.init(document.getElementById('timer'));
        Countdown.init(document.getElementById('countdown'));
        Instructions.init(document.getElementById('instructions'));
        Log.init();
        Version.init();

        var timer = document.getElementById('timer')
        timer.addEventListener('click', function () {
            Countdown.start(60);
        });
    }, "");

</script>
</body>
</html>
