// public_html/components/logout.js
//
//
// Logout currently logged in user.

var Logout = (function () {
    var element;

    function logout(event) {
        event.preventDefault();
        console.log('Logout...');
        const xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function(event) {
            console.log(this.status);
            if (this.status == 204) {
                window.location = site;
            } else {
                console.log('failed');
            }
        })
        xhr.open("POST", api + "logout");
        xhr.send();
    }

    // Public
    function init(elem) {
        element = elem;
        element.addEventListener('click', logout);
    }

    return {
        init: init
    };
})();