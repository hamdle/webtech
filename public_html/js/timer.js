// Timer
//
//
// Display a timer that starts at zero and counts up. 
//
// Use Utils

var Timer = (function () {
    var start_time;
    var end_time;
    var elapsed_time;
    var element;
    const one_second = 1000;

    function elapsed() {
        if (start_time === 0) {
            return 0;
        }

        if (end_time === null) {
            var current_time = new Date();
            var time_diff = current_time - start_time;
            elapsed_time = Math.round(time_diff / one_second);
        }

        return elapsed_time;
    }

    // Event handlers
    function updateHandler() {
        element.innerHTML = Utils.formatTime(elapsed(), Utils.get('MINUTES'), false);
        //element.innerHTML = Utils.formatTime(elapsed(), Utils.get('FLEX'), true);
    }

    // Public
    function init(elem) {
        start_time = 0;
        end_time = null;
        elapsed_time = 0;
        element = elem;
        updateHandler();
        setInterval(updateHandler, one_second);
    }

    function start() {
        start_time = new Date();
    }

    function stop() {
        end_time = new Date();
    }

    return {
        init: init,
        start: start,
        stop: stop
    };
})();
