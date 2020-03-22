/* 
 * Workoutron component
 *
 * Consume an exercise from the list and provide an interface 
 * and display.
 *
 */
var Workoutron = (function () {
    var $element
    var $exercise_list
    var $exercise

    // Class Api.
    function init(element, workout_element) {
        $element = element
        $exercise_list = document.getElementById('exercise__list')
        $exercise = null
    }

    function next() {
        get()
        display()
    }

    // Helper functions
    function get() {
        var list_items = $exercise_list.getElementsByTagName('li')
        if (list_items.length === 0) {
            $exercise = null;
            return
        }

        var select = list_items[0].getElementsByTagName('select')[0]

        $exercise = {
            name: select.selectedOptions[0].value,
            id: select.selectedOptions[0].getAttribute('data-id'),
            sets: select.selectedOptions[0].getAttribute('data-sets'),
            rest_in_seconds: 60
        }

        pop(list_items[0]);
    }

    function pop(select) {
        select.parentNode.removeChild(select)
    }

    function display() {
        if ($exercise === null) {
            $element.innerHTML = "No exercise."
            return
        }

        $element.innerHTML = $exercise.name;
    }

    return {
        init: init,
        next: next
    };
})();
