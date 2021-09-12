// javascript/components/log.js
//
//
// This component retrieves and displays previous workouts in the workout log.

var Log = (function() {
    var xhr;
    var $element;

    function buildLog(workouts) {
        log = document.getElementById("log");
        Object.values(workouts).forEach(function (entry) {
            var div = document.createElement("div");
            div.classList = "log__entry";
            div.innerHTML = "<span class=\"log__title\">" + entry.start + "</ span>";
            var button = document.createElement("a");
            button.classList = "button";
            button.innerHTML = "Load";
            div.appendChild(button);
            log.appendChild(div);
            console.log(entry);
        });
    }

    // Request handlers
    function exerciseHandler() {
        if (this.status !== 200) {
            var par = document.createElement("p");
            par.textContent = "Error loading workout log.";
            $element.appendChild(par);
            return;
        }

        buildLog(JSON.parse(this.responseText));
    }

    // Public
    function init(element) {
        $element = element;
        // Get list of exercises from the Api.
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", exerciseHandler);
        xhr.open("GET", api + "workouts");
        xhr.send();
    }

    return {
        init: init
    };
})();
