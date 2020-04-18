/* 
 * Input Display component
 *
 * Consume an exercise from the list and provide an interface 
 * and display.
 *
 * Use RoutineBuilder
 * Use Workout
 * Use Timer
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
        if ($exercise !== null) {
            var reps = []
            inputs = $element.getElementsByTagName('input')

            for (var n = 0; n < inputs.length; n++) {
                var rep = {
                    amount: inputs[n].value
                };
                
                reps.push(rep)
            }

            $exercise['reps'] = reps
            $exercise['sets'] = inputs.length
        }
        getExercise()
        displayAndUpdate()
    }

    // Helper functions
    function getExercise() {
        $exercise = RoutineBuilder.pop()
    }

    function displayAndUpdate() {
        clearDisplay()

        if ($exercise === null) {
            displayDone()
            completeWorkout()
        } else {
            displayExercise()
            updateWorkout()
        }
    }

    function clearDisplay() {
        while ($element.firstChild) {
            $element.removeChild($element.firstChild)
        }
    }

    function displayDone() {
        var div_finish = document.createElement('div')
        div_finish.id = $name + '__finish--large'
        div_finish.className = $name + '__finish--large'
        div_finish.innerHTML = 'Workout complete.'
        $element.appendChild(div_finish)
        var div_finish_small = document.createElement('div')
        div_finish_small.id = $name + '__finish--small'
        div_finish_small.className = $name + '__finish--small'
        div_finish_small.innerHTML = 'Good job!'
        $element.appendChild(div_finish_small)

    }

    function updateWorkout() {
        Workout.addExercise($exercise);
    }

    function completeWorkout() {
        Timer.stop();
        Workout.complete()
    }

    function displayExercise() {
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
        div_sets.innerHTML = $exercise.sets + 'x'
        div_input.appendChild(div_sets)

        for (var i = 0; i < $exercise.sets; i++) {
            var input = document.createElement('input')
            input.className = $name + '__textbox'
            input.id = $name + '__textbox--' + i
            div_input.appendChild(input)
            if (i + 1 < $exercise.sets) {
                var span_plus = document.createElement('span');
                span_plus.className = $name + '__plus'
                span_plus.innerHTML = ' + '
                div_input.appendChild(span_plus)
            }
        }

        var next_button = document.createElement('a')
        next_button.id = $name + '__next-button'
        next_button.className = $name + '__next-button'
        next_button.innerHTML = 'Next exercise'
        $element.appendChild(next_button)

        next_button.addEventListener('click', nextButtonHandler);
    }

    // Request handlers.
    function nextButtonHandler() {
        next()
    }

    return {
        init: init,
        next: next
    };
})();
