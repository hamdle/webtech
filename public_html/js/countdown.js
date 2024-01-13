// Countdown
//
// A reusable timer that, given an amount of time in seconds, counts down.
//
// include Utils

var Countdown = (function () {
    var $amount;
    var $element;
    var start_time;
    var $interval;
    var $sound;
    var $playSound;

    const one_second = 1000;

    function calcValue() {
        var current_time = new Date();
        var time_diff = start_time - current_time;
        var count = Math.abs(Math.round(time_diff / one_second));

        return Math.max($amount - count, 0)
    }

    function clearDisplay(value) {
        $element.innerHTML = value;
    }

    function displayCountdown(countdown) {
        if (countdown === 0) {
            $element.classList.add('expired');
        } else {
            $element.classList.remove('expired');
        }

        $element.innerHTML = Utils.formatTime(countdown, Utils.get('FLEX'), true);
    }

    // Event handlers
    function updateHandler() {
        var countdown = calcValue();
        if (countdown == 0) {
            if ($playSound) {
                $sound.play();
            }
            clearInterval($interval);
        }
        displayCountdown(countdown);
    }

    // Public
    function init(elem, playSound) {
        $element = elem;
        $playSound = playSound;
        $sound = new Audio(site + "sound/ding.mp3")
    }

    function start(value) {
        $amount = parseInt(value)
        clearInterval($interval);
        clearDisplay($amount)
        start_time = new Date()
        updateHandler()
        $interval = setInterval(updateHandler, one_second)
    }

    return {
        init: init,
        start: start,
    };
})();
