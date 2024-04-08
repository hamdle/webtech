// ScreenWake
//
//
// Keep screen on while performing exercises

var ScreenWake = (function() {
    var $element;

    function onClickHandler(event) {
        console.log("click");
    }

    function init(elem) {
        $element = elem;
        $element.addEventListener('click', onClickHandler);
    }

    return {
        init: init
    }
})();