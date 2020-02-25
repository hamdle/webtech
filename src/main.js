// main.js
//
// This is the entry point for all Javascript code executed in the App.

let siteUrl = "http://workout.local/api/";

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
    // Workout builder component
    var Builder = (function() {
        var xhr;
        
        function load() {
            // Get list of exercises from the Api.
            xhr = new XMLHttpRequest();
            xhr.addEventListener("load", exerciseHandler);
            xhr.open("GET", siteUrl + 'exercises');
            xhr.send();

            // Load button handlers.
            window.addEventListener("load", function() {
                loadAdd();
                loadRemove();
                loadStart();
            });
        }

        function loadAdd() {
            // Create button to add new exercise to the routine.
            var add = document.getElementById('exercise__button--add');
            add.addEventListener('click', addHandler);
        }

        function loadRemove() {
            // Remove exercises from the bottom of the routine..
            var remove = document.getElementById('exercise__button--remove');
            remove.addEventListener('click', removeHandler);
        }

        function loadStart() {
            // Setup Start button handler.
            var start = document.getElementById('start__button');
            start.addEventListener('click', startHandler);
        }

        // Request handlers.
        function exerciseHandler() {
            if (this.status !== 200) {
                var list = document.getElementById('exercise__list');
                var par = document.createElement('p');
                par.textContent = 'Error loading exercises.';
                list.appendChild(par);
                return;
            }

            exercises = JSON.parse(this.responseText);
            console.log(exercises);

            var list = document.getElementById('exercise__list');
            var listItem = document.createElement('li');
            var selectList = document.createElement('select');

            list.appendChild(listItem);
            listItem.appendChild(selectList);

            exercises.forEach(function(item, index) {
                var option = document.createElement('option');
                option.value = item.title;
                option.text = item.title;
                option.setAttribute('data-id', item.id);
                option.setAttribute('data-sets', item.default_sets);
                selectList.appendChild(option);
            });
        }

        function addHandler() {
            var list = document.getElementById('exercise__list');
            var listItem = document.createElement('li');
            var selectList = document.createElement('select');

            list.appendChild(listItem);
            listItem.appendChild(selectList);

            exercises.forEach(function(item, index) {
                var option = document.createElement('option');
                option.value = item.title;
                option.text = item.title;
                option.setAttribute('data-id', item.id);
                option.setAttribute('data-sets', item.default_sets);
                selectList.appendChild(option);
            });
        }

        function removeHandler() {
            var list = document.getElementById('exercise__list');
            if (list.childNodes.length > 2 &&
                list.childNodes[list.childNodes.length-1].nodeName === "LI") {
                list.removeChild(list.childNodes[list.childNodes.length-1]);
            }
        }

        function startHandler() {
            if (window.confirm("Are you ready to start the workout?")) {
                var timer = document.getElementById('timer');
                timer.innerHTML = new Date().getTime();
            }
        }

        return {
            init: load
        };
    })();

    Builder.init();
}

// index.php
function runIndex() {
    window.addEventListener("load", function() {
        function sendData() {
            const request = new XMLHttpRequest();

            const formData = new FormData(form);

            request.addEventListener('load', function(event) {
                console.log(event.target.responseText);
            });

            request.addEventListener('error', function(event) {
                console.log('Error!');
            });

            request.open("POST", siteUrl + 'login');

            request.send(formData);
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
    request.open("GET", siteUrl + '1/workouts/new');
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
