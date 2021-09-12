// main.js
//
// This is the entry point for all Javascript code executed in the App.

let api = "http://workout.local/api/";
let site = "http://workout.local/";

let routes = [ 
    // Public pages
    '',
    // Auth pages
    'home/',
    'go/',
]

let path = location.pathname.substring(1)

routes.map(function (uri, index) {
    if (path == uri) {
        switch (index) {
            case 0: 
                runIndex()
                break
            case 1:
                runHome()
                break
            case 2:
                runGo()
        }
    }
})

function runIndex() {
    window.addEventListener("load", function() {
        // Send login form data to Api and redirect on success
        function sendData() {
            const $xhr = new XMLHttpRequest();
            const formData = new FormData(form);

            // TODO: Clean this up. Don't need both of thses.
            $xhr.addEventListener('load', function(event) {
                //console.log(event.target.responseText);
                //window.location = site + 'go';
            });
            $xhr.onreadystatechange = function() {
                if ($xhr.readyState == XMLHttpRequest.DONE) {
                    if (this.status == 201) {
                        window.location = site + 'home';
                    } else {
                        console.log('Login failed. Response code: '+this.status);
                    }
                }
            }
            $xhr.addEventListener('error', function(event) {
                console.log('An error occured while logging in.');
            });
            $xhr.open("POST", api + 'login');
            // Specifying a header here could cause the POST data to be send
            // incorrectly, don't set it explicitly and let the broswer generate
            // the correct one automatically
            $xhr.send(formData);
        }

        // Run on load.
        let form = document.getElementById('loginForm');
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            sendData();
        });
    });
}

function runHome() {
    VerifyUser.failure('');
    Log.init();
}

function runGo() {
    VerifyUser.failure('');

    // Init components.
    Workout.init();
    RoutineBuilder.init(document.getElementById('exercise__list'));
    Startbutton.init(startHandler);
    Timer.init(document.getElementById('timer'));
    Countdown.init(document.getElementById('countdown'));
    Instructions.init(document.getElementById('instructions'));
    Log.init();
    Version.init();
    
    // Event handlers.
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

    // Reset cooldown timer to 60 sec when the users clicks the timer.
    var timer = document.getElementById('timer')
    timer.addEventListener('click', function () {
        Countdown.start(60);
    });
}
