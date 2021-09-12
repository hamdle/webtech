/*
 * Workout builder component
 *
 */
var Version = (function() {
    var xhr;
    var $element;

    // Get version of application from the Api.
    function load(element) {
        $element = element;
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", exerciseHandler);
        xhr.open("GET", api + 'version');
        xhr.send();
    }

    // Helper functions
    
    // Request handlers.
    function exerciseHandler() {
        if (this.status !== 200) {
            var par = document.createElement('p');
            par.textContent = 'Error loading exercises.';
            $element.appendChild(par);
            return;
        }

        var response = JSON.parse(this.responseText);
        var dom = document.getElementById('version');
        dom.textContent = response.version;
    }

    return {
        init: load,
    };
})();
