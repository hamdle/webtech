// Logout
//
// Send request to delete user cookie to logout user

var Logout = (function () {
    var element;
    var api;
    var site;

    function logout(event) {
        event.preventDefault();

        const $xhr = new XMLHttpRequest();

        // $xhr.addEventListener("load", function(event) {
        //     const response = JSON.parse(event.target.responseText);
        //     if (response.ok == 'true') {
        //         window.location = site;
        //     }
        // })
        $xhr.addEventListener('readystatechange', function(event)
        {
            if ($xhr.readyState == XMLHttpRequest.DONE)
            {
                const response = JSON.parse(event.target.responseText);
                if (response.ok === 'false' || response.hasOwnProperty('warning') || response.hasOwnProperty('error')) {
                    return;
                }
                if (response.ok === 'true') {
                    window.location = site;
                }
            }
        });
        $xhr.addEventListener('error', function(event)
        {
            console.log('An error occured while logging in.');
        });
        $xhr.open("POST", api);
        $xhr.setRequestHeader('Content-type', 'application/json');
        $xhr.send(JSON.stringify({
            method: "Auth.logout"
        }));
    }

    // Public
    function init(_api, _site, elem) {
        api = _api;
        site = _site;
        element = elem;
        element.addEventListener('click', logout);
    }

    return {
        init: init
    };
})();