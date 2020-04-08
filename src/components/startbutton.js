// Startbutton component
var Startbutton = (function() {
    var $element

    function load(clickHandler) {
        window.addEventListener("load", startHandler)

        function startHandler() {
            $element = document.getElementById('start__button')
            $element.addEventListener('click', clickHandler)
        }
    }

    function disable() {
        $element.classList.add('start__button--disabled')    
    }

    return {
        init: load,
        disable: disable
    };
})();
