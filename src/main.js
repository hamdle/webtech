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
        //request.open("GET", "http://stg.ericmarty.local/wo/api/22/programs/new");
        var requestData = JSON.stringify({email: "admin@localhost", password: "password"});
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send(requestData);
    }

    function loginListener() {
        responseData = JSON.parse(this.responseText);
        console.log(this.status);
        console.log(responseData);
        document.getElementById('login').outerHTML = 'Welcome, ' + responseData['user'];
    }
}

// /ready
function runReady() {
    // This request sends a simple GET request
    function requestListener() {
        responseData = JSON.parse(this.responseText);
        console.log(this.status);
        console.log(responseData);
        document.getElementById('program').outerHTML = 'Welcome, ' + responseData['program'];
    }

    var request = new XMLHttpRequest();
    request.addEventListener("load", requestListener);
    request.open("GET", "http://stg.ericmarty.local/wo/api/22/programs/new");
    request.send();
}

// /workout
function runWorkout() {
    // TODO
}
