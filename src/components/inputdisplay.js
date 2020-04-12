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
                    entries_id: null,
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
        div_finish.id = $name + '__finish'
        div_finish.className = $name + '__finish'
        div_finish.innerHTML = 'Done'
        $element.appendChild(div_finish)

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
        div_sets.innerHTML = $exercise.sets + 'x' + $exercise.exercises_id
        div_input.appendChild(div_sets)

        for (var i = 0; i < $exercise.sets; i++) {
            var input = document.createElement('input')
            input.className = $name + '__textbox'
            input.id = $name + '__textbox--' + i
            div_input.appendChild(input)
        }

        var next_button = document.createElement('button')
        next_button.id = $name + '__next-button'
        next_button.innerHTML = 'Next'
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
