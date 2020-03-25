/* 
 * Input Display component
 *
 * Consume an exercise from the list and provide an interface 
 * and display.
 *
 * Uses RoutineBuilder
 *
 */
var InputDisplay = (function () {
    var $element
    var $exercise
    var $name

    // Class Api.
    function init(element) {
        $element = element
        $exercise = null
        $name = 'input-display'
    }

    function next() {
        get()
        display()
    }

    // Helper functions
    function get() {
        $exercise = RoutineBuilder.pop();
    }


    function display() {
        clear()

        if ($exercise === null) {
            //$element.innerHTML = "<div id='finish' class='finish'>Done</div>"
            var div_finish = document.createElement('div')
            div_finish.id = $name + '__finish'
            div_finish.className = $name + '__finish'
            div_finish.innerHTML = 'Done'
            $element.appendChild(div_finish)
            return
        }

        var div_label = document.createElement('div')
        div_label.id = $name + '__exercise--label'
        div_label.className = $name + '__exercise--label'
        div_label.innerHTML = $exercise.name
        $element.appendChild(div_label)


        var div_input = document.createElement('div')
        div_input.id = $name + '__exercise--input'
        div_input.className = $name + '__exercise--input'
        $element.appendChild(div_input)


        var div_sets = document.createElement('div')
        div_sets.id = $name + '__exercise--sets'
        div_sets.className = $name + '__exercise--sets'
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
