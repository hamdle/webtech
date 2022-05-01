// public_html/components/log.js
//
//
// Build a list of exercise entries, called the log. This component attaches to
// the element of id = "log"

//let api = "http://workout.local/api/";

var Log = (function() {
    var xhr;

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

    function logHandler() {
        buildLog(JSON.parse(this.responseText));
    }

    // Public
    function init() {
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", logHandler);
        xhr.open("GET", api + "workouts");
        xhr.send();
    }

    return {
        init: init
    };
})();
