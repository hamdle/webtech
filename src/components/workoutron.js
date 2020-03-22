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
    function init(element, exercise_list) {
        $element = element
        $exercise_list = exercise_list
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

        var select = pop(list_items)
        if (select === null) {
            $exercise = null;
            return;
        }

        $exercise = {
            name: select.selectedOptions[0].value,
            id: select.selectedOptions[0].getAttribute('data-id'),
            sets: select.selectedOptions[0].getAttribute('data-sets'),
            rest_in_seconds: 60
        }
    }

    function pop(list_items) {
        var selects = list_items[0].getElementsByTagName('select')
        if (selects.length === 0) {
            return null
        }

        var select = selects[0]

        list_items[0].parentNode.removeChild(list_items[0])

        return select
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
