// main.js
//
// This is the entry point for all Javascript code executed in the App.

let routes = [ 
    'wo/app/',
    'wo/app/ready/',
    'wo/app/workout/']

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
    var loginElement = document.getElementById('login');
    loginElement.onclick = login;

    function login() {
        // This request sends a sample POST request, with data
        var request = new XMLHttpRequest();
        request.addEventListener("load", loginListener);
        request.open("POST", "http://stg.ericmarty.local/wo/api/authenticate");
        //var requestData = JSON.stringify({email: "admin@localhost.com", password: "password123"});
        var requestData = JSON.stringify({id: "1"});
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send(requestData);
    }

    function loginListener() {
        responseData = JSON.parse(this.responseText);
        console.log(this.status);
        console.log(responseData);
        // TODO Add auth cookie.
        document.getElementById('login').outerHTML = 'Welcome, <strong>' + responseData['user'] + '</strong>';
    }
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
    request.open("GET", "http://stg.ericmarty.local/wo/api/1/workouts/new");
    request.send();
}

// /workout
function runWorkout() {
    // TODO
}
