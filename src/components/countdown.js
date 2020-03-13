/* 
 * Countdown component
 *
 * A reusable timer that, given an amount of time in seconds, counts down.
 *
 * Use Utils
 *
 */
var Countdown = (function () {
    var start_time;
    var amount;
    var element;
    var reset;
    var events = new Array();
    var interval_id;

    const one_second = 1000;

    // Class Api.
    function init(elem) {
        start_time = 0;
        element = elem;
        reset = true;
        interval_id = null;
    }

    function start(value) {
        if (interval_id != null) {
            clearInterval(interval_id);
            clearDisplay();
            start_time = new Date();
            reset = true;
        }
        amount = value;
        interval_id = setInterval(updateHandler, one_second);
    }

    function add(handler) {
        events.push(handler);
    }

    // Helper functions.
    function calcValue() {
        if (reset) {
            start_time = new Date();
            reset = false;
        }
        var current_time = new Date();
        var time_diff = start_time - current_time;
        var count = Math.abs(Math.round(time_diff / one_second));

        return Math.max(amount - count, 0)
    }

    function fireEvents() {
        for (var i = 0; i < events.length; i++) {
            const event = events.shift();
            event();
        }
    }

    function clearDisplay() {
        element.innerHTML = '';
    }

    function displayCountdown(countdown) {
        var run_events = false;

        if (countdown === 0) {
            element.classList.add('expired');
            if (events.length > 0) {
                run_events = true;
            }
        } else {
            element.classList.remove('expired');
        }

        element.innerHTML = Utils.formatTime(countdown, Utils.get('FLEX'), true);

        if (run_events) {
            fireEvents();
        }
    }

    // Event handlers.
    function updateHandler() {
        var countdown = calcValue();
        displayCountdown(countdown);
    }

    return {
        init: init,
        add: add,
        start: start,
    };
})();
