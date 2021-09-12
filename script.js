// script.js
//
//
// This is the login page.

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

    let form = document.getElementById('loginForm');
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        sendData();
    });
});
