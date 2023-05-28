// JumpToInput
//
//
// Jump to next input when timer is pressed.
//
// Use Utils

var JumpToInput = (function () {
    var timerElement;
    var inputDisplayId;

    // Event handlers
    function onClickHandler() {
        var display = document.getElementById(inputDisplayId);
        var inputs = display.getElementsByTagName('input');
        var i;
        for (i = 0; i < inputs.length; i++) {
            if (inputs[i].value === undefined || inputs[i].value === "") {
                inputs[i].focus();
                break;
            }
        }
    }

    // Public
    function init(element, id) {
        timerElement = element;
        inputDisplayId = id;
        timerElement.addEventListener('click', onClickHandler);
    }

    return {
        init: init
    };
})();
