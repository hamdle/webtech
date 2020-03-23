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
        clear()

        if ($exercise === null) {
            //$element.innerHTML = "<div id='finish' class='finish'>Done</div>"
            var div_finish = document.createElement('div')
            div_finish.id = 'workoutron__finish'
            div_finish.className = 'workoutron__finish'
            div_finish.innerHTML = 'Done'
            $element.appendChild(div_finish)
            return
        }

        var div_label = document.createElement('div')
        div_label.id = 'workoutron__exercise--label'
        div_label.className = 'workoutron__exercise--label'
        div_label.innerHTML = $exercise.name
        $element.appendChild(div_label)


        var div_input = document.createElement('div')
        div_input.id = 'workoutron__exercise--input'
        div_input.className = 'workoutron__exercise--input'
        $element.appendChild(div_input)


        var div_sets = document.createElement('div')
        div_sets.id = 'workoutron__exercise--sets'
        div_sets.className = 'workoutron__exercise--sets'
        div_sets.innerHTML = $exercise.sets + 'x' + $exercise.id
        div_input.appendChild(div_sets)

        for (var i = 0; i < $exercise.sets; i++) {
            var input = document.createElement('input')
            div_input.appendChild(input)
        }
    }

    function clear() {
        while ($element.firstChild) {
            $element.removeChild($element.firstChild)
        }
    }

    return {
        init: init,
        next: next
    };
})();
