/*
 * Instructions component
 *
 * Display instructions to help the user get started. Should
 * help explian how to 1) build a routine and 2) start a workout.
 *
 */
var Instructions = (function() {
    var $element

    // Class Api.
    function init(element) {
        $element = element
    }

    function hide() {
        $element.setAttribute('style', 'display: none');
    }

    return {
        init: init,
        hide: hide
    };
})();
