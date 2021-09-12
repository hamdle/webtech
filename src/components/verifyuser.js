/* 
 * Verify User componenet
 *
 * Provide functions to redirect to a different page if a
 * user is, or is not, logged in.
 *
 */
var VerifyUser = (function () {
    // Helper functions.
    function verifyUser(uri, success) {
        const xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function(event) {
            console.log(this.status);
            if (this.status == 200) {
                if (success) {
                    window.location = site + uri;
                }
            } else {
                if (!success) {
                    window.location = site + uri;
                }
            }
        })
        xhr.open("GET", api + 'auth');
        xhr.send();
    }

    // Class Api.
    function failure(redirect) {
        verifyUser(redirect, false);
    }

    function success(redirect) {
        verifyUser(redirect, true);
    }

    return {
        failure: failure,
        success: success
    };
})();
