// main.js
//
// This is the entry point for all Javascript code executed in the App.

let siteUrl = "http://workout.local/api/";

let routes = [ 
    '',
    'ready/',
    'workout/']

let path = location.pathname.substring(1)

routes.map(run);

function run(uri, index) {
    if (path == uri) {
        switch (index) {
            case 0: 
                runIndex()
                break
            case 1:
                runReady()
                break
            case 2:
                runWorkout()
                break
        }
    }
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

// /workout
function runWorkout() {
    // TODO
}
