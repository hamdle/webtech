// javascript/components/verifyuser.js
//
// 
// Redirect the page if a user is or is not logged in.

var VerifyUser = (function () {
    function verifyUser(uri, success, onSuccess) {
        const xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function(event) {
            console.log(this.status);
            if (this.status == 200) {
                if (success) {
                    window.location = site + uri;
                }
                if (onSuccess) {
                    onSuccess();
                }
            } else {
                if (!success) {
                    window.location = site + uri;
                }
            }
        })
        xhr.open("GET", api + "auth");
        xhr.send();
    }

    // Public
    function failure(redirect, onSuccess) {
        verifyUser(redirect, false, onSuccess);
    }

    function success(redirect, onSuccess) {
        verifyUser(redirect, true, onSuccess);
    }

    return {
        failure: failure,
        success: success
    };
})();
