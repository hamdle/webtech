// public_html/component/startbutton.js
//
//
// Call anonymous function on Start Button click

var Startbutton = (function() {
    var $element
    var $handler

    // Public
    function load(clickHandler) {
        $handler = clickHandler
        window.addEventListener("load", startHandler)

        function startHandler() {
            $element = document.getElementById('start__button')
            $element.addEventListener('click', clickHandler)
        }
    }

    function disable() {
        $element.classList.add('start__button--disabled')
        $element.classList.remove('button')
        $element.innerHTML = "Workout in progress..."
        $element.removeEventListener('click', $handler, false)
    }

    return {
        init: load,
        disable: disable
    };
})();
