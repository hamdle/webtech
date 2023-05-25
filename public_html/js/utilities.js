// Utils
//
//
// A collection of helper functions for other component
// to use.
//
// TODO shorten this to Utils.js

var Utils = (function() {
    const constants = 
    {
        'SECONDS': 'seconds',
        'MINUTES': 'minutes',
        'HOURS': 'hours',
        'FLEX': 'flex'
    }

    // Public
    function formatSecondsToTime(time_in_seconds, display, smart_zeroes) {
        var seconds = parseInt(time_in_seconds, 10);
        var hours = Math.floor(seconds / 3600);
        var minutes = Math.floor((seconds - (hours * 3600)) / 60);
        var seconds = seconds - (hours * 3600) - (minutes * 60);

        if (!smart_zeroes) {
            if (hours < 10)
                hours = "0" + hours;
            if (minutes < 10)
                minutes = "0" + minutes;
            if (seconds < 10)
                seconds = "0" + seconds;
        }
        else {
            if (minutes > 0) {
                if (seconds < 10)
                    seconds = "0" + seconds;
            }
            if (hours > 0) {
                if (minutes < 10)
                    minutes = "0" + minutes;
            }
        }

        if (display === constants.SECONDS) {
            return seconds;
        }
        else if (display === constants.MINUTES) {
            return minutes + ':' + seconds;
        }
        else if (display === constants.HOURS) {
            return hours + ':' + minutes + ':' + seconds;
        }
        else if (display === constants.FLEX) {
            return ((hours > 0) ? hours + ':': '') +
                ((minutes > 0) ? minutes + ':': '') +
                seconds;
        }

        return hours + ':' + minutes + ':' + seconds;
    }

    return {
        formatTime: formatSecondsToTime,
        get: function(name) { return constants[name]; }
    };
})();
