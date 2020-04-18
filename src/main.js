// main.js
//
// This is the entry point for all Javascript code executed in the App.

let siteApi = "http://workout.local/api/";
let site = "http://workout.local/";

let routes = [ 
    // Public pages
    '',
    // Auth pages
    'go/',
    'stats/',
    'exercises/',
    'settings/',
]

let path = location.pathname.substring(1)

routes.map(function (uri, index) {
    if (path == uri) {
        switch (index) {
            case 0: 
                loadTooltips()
                runIndex()
                break
            case 1:
                verifyLogin();
                loadTooltips()
                runGo()
                break
            case 2:
            case 3:
            case 4:
                verifyLogin();
                loadTooltips()
        }
    }
})

// /go
function runGo() {
    // Init components.
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
        Countdown.add(nextExerciseHandler);
        Countdown.start(120);
    }

    function nextExerciseHandler() {
        Countdown.add(nextExerciseHandler);
        Countdown.start(60);
    }
}

// /
function runIndex() {
    // Redirect to /go if the user is already logged in
    VerifyUser.success('go');

    window.addEventListener("load", function() {
        // Helper functions.
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

        // Run on load.
        let form = document.getElementById('loginForm');

        // Handle login submit through Api.
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            sendData();
        });
    });
}

// Helper functions.
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

function verifyLogin() {
    // Requires verifyuser.js
    VerifyUser.failure('');
}
