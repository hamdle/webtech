/* 
 * Timer component
 *
 * Maintain and display a timer that counts up from 0. 
 *
 * Use Utils
 *
 */
var Timer = (function () {
    var start_time;
    var end_time;
    var elapsed_time;
    var element;
    const one_second = 1000;

    // Class Api.
    function init(elem) {
        start_time = 0;
        end_time = 0;
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

    // Helper functions.
    function elapsed() {
        var current_time = new Date();

        if (start_time === 0) {
            return 0;
        }
        var time_diff = current_time - start_time;
        elapsed_time = Math.round(time_diff / one_second);

        return elapsed_time;
    }

    // Event handlers.
    function updateHandler() {
        //element.innerHTML = Utils.formatTime(elapsed(), Utils.format('HOURS'), false);
        element.innerHTML = Utils.formatTime(elapsed(), Utils.get('FLEX'), true);
    }

    return {
        init: init,
        start: start,
        stop: stop
    };
})();
