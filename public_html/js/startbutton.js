// Startbutton
//
//
// Call anonymous function on Start Button click

var Startbutton = (function() {
    var $element
    var $handler

    // Public
    function init(element, clickHandler, bypass = false) {
        $element = element;
        if (bypass) {
            clickHandler(false);
        } else {
            $handler = clickHandler;
            window.addEventListener("load", startHandler)

            function startHandler() {
                $element.addEventListener('click', clickHandler)
            }
        }
    }

    function disable() {
        $element.classList.add('start__button--disabled')
        $element.classList.remove('button')
        $element.innerHTML = "Workout in progress..."
        $element.removeEventListener('click', $handler, false)
    }

    function press() {
        $element = document.getElementById('start__button');
        var event = new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
        });
        $element.dispatchEvent(event);
    }

    return {
        init: init,
        disable: disable,
        press: press
    };
})();
