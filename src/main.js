// main.js
//
// This is the entry point for all Javascript code executed in the App.

let siteApi = "http://workout.local/api/";
let site = "http://workout.local/";

let routes = [ 
    '',
    'start-a-workout/',
    'stats/',
    'exercises/',
    'settings/',
    'go/'
]

let path = location.pathname.substring(1)

routes.map(run);

function run(uri, index) {
    if (path == uri) {
        switch (index) {
            case 0: 
                loadTooltips();
                runIndex()
                break
            case 1:
                loadTooltips();
                break
            case 2:
                loadTooltips();
                break
            case 3:
                loadTooltips();
                break;
            case 4:
                loadTooltips();
                break;
            case 5:
                loadTooltips();
                go();
        }
    }
}

// go.php
function go() {
    Workout.init();
    RoutineBuilder.init(document.getElementById('exercise__list'));
    Startbutton.init(startHandler);
    Timer.init(document.getElementById('timer'));
    Countdown.init(document.getElementById('countdown'));
    Instructions.init(document.getElementById('instructions'));
    
    // Event handlers.
    function startHandler() {
        Startbutton.disable();
        Instructions.hide();
        Workout.create();
        InputDisplay.init(document.getElementById('inputdisplay'));
        InputDisplay.next();
        Timer.start();
        //Countdown.add(nextExerciseHandler);
        //Countdown.start(3);
    }

    /*function nextExerciseHandler() {
        Workoutron.next();
    }*/
}

// index.php
function runIndex() {
    window.addEventListener("load", function() {
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
                    if (this.status == 200) {
                        window.location = site + 'go';
                    } else {
                        console.log('login failed.');
                    }
                }
            }
            $xhr.addEventListener('error', function(event) {
                console.log('Error!');
            });
            $xhr.open("POST", siteApi + 'login');
            $xhr.send(formData);
        }

        let form = document.getElementById('loginForm');

        // Take over submit
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            sendData();
        });
    });
}

// /ready
function runReady() {
    // This request sends a simple GET request
    function requestListener() {
        console.log(this.responseText);
        responseData = JSON.parse(this.responseText);
        console.log(this.status);
        console.log(responseData);
        document.getElementById('program').outerHTML = 'Workout for <strong>' + responseData['user']  + '</strong>' + responseData['workout_html'];
    }

    var request = new XMLHttpRequest();
    request.addEventListener("load", requestListener);
    request.open("GET", siteApi + '1/workouts/new');
    request.send();
}

function loadTooltips() {
    window.addEventListener('load', function() {
    const buttons = document.querySelectorAll('.menu__link');
    for (var i = 0; i < buttons.length; i++) {
        var btn = buttons[i];
        /*btn.addEventListener('click', function() {
            console.log('click');
        });*/
        btn.onmouseover = function() {
            var tooltip = event.target.querySelectorAll('.menu__tooltip');
            if (tooltip[0] !== undefined) {
                tooltip[0].className = 'menu__tooltip--show';
            }
        };
        btn.onmouseout = function() {
            var tooltip = event.target.querySelectorAll('.menu__tooltip--show');
            if (tooltip[0] !== undefined) {
                tooltip[0].className = 'menu__tooltip';
            }
        };
    }
    });
}
