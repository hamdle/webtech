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
