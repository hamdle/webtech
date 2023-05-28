// instructions.js
//
//
// Display instructions to help the user get started. Should
// help explian how to 1) build a routine and 2) start a workout.
//
// TODO generalize this component, what do the instructions have to do with this?
 
 
var Instructions = (function() {
    var $element

    // Public
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
