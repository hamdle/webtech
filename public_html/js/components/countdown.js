// public_html/components/countdown.js
//
// A reusable timer that, given an amount of time in seconds, counts down.
//
// include Utils
// TODO use import

var Countdown = (function () {
    var amount;
    var element;
    var start_time;
    var interval;

    const one_second = 1000;

    function calcValue() {
        var current_time = new Date();
        var time_diff = start_time - current_time;
        var count = Math.abs(Math.round(time_diff / one_second));

        return Math.max(amount - count, 0)
    }

    function clearDisplay(value) {
        element.innerHTML = value;
    }

    function displayCountdown(countdown) {
        if (countdown === 0) {
            element.classList.add('expired');
        } else {
            element.classList.remove('expired');
        }

        element.innerHTML = Utils.formatTime(countdown, Utils.get('FLEX'), true);
    }

    // Event handlers
    function updateHandler() {
        var countdown = calcValue();
        displayCountdown(countdown);
    }

    // Public
    function init(elem) {
        element = elem;
    }

    function start(value) {
        clearInterval(interval);
        clearDisplay(value)
        start_time = new Date()
        amount = parseInt(value)
        updateHandler()
        interval = setInterval(updateHandler, one_second)
    }

    return {
        init: init,
        start: start,
    };
})();
