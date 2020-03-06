// Startbutton component
var Startbutton = (function() {
    var xhr;

    function load(clickHandler) {
        // TODO: Get a new exercise id for this workout from the Api.

        window.addEventListener("load", startHandler);

        function startHandler() {
            var start = document.getElementById('start__button');
            start.addEventListener('click', clickHandler);
        }
    }

    return {
        init: load
    };
})();
