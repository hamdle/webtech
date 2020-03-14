/* 
 * Workoutron component
 *
 * Consume an exercise from the list and provide an interface 
 * and display.
 *
 */
var Workoutron = (function () {
    var $element;
    var $exercise_list;

    // Class Api.
    function init(element, workout_element) {
        $element = element;
        $exercise_list = document.getElementById('exercise__list');
    }

    function next() {
        var lis = $exercise_list.getElementsByTagName('li');
        var sel = lis[0].getElementsByTagName('select');
        console.log(sel[0].selectedOptions[0].value);
    }

    return {
        init: init,
        next: next
    };
})();
