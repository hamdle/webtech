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

    const WARM_UP_ID = 1;

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
        // TODO: Replace this magic number with value from user settings.
        Countdown.start(120)
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
        // Exercise name
        var div_label = document.createElement('div')
        div_label.id = $name + '__exercise--label'
        div_label.className = $name + '__exercise--label'
        div_label.innerHTML = $exercise.name

        if ($exercise.exercises_id != WARM_UP_ID) {
            // 'Add' button.
            var div_label_add = document.createElement('span')
            div_label_add.className = $name + '-exercise__button--add'
            div_label_add.innerHTML = 'Add'
            // Add set handler.
            div_label_add.addEventListener('click', addSetHandler);
            div_label.appendChild(div_label_add)

            // 'Remove' button.
            var div_label_remove = document.createElement('span')
            div_label_remove.className = $name + '-exercise__button--remove'
            div_label_remove.innerHTML = 'Remove'
            // Remove set handler.
            div_label_remove.addEventListener('click', removeSetHandler);
            div_label.appendChild(div_label_remove)
        }

        $element.appendChild(div_label)

        // 2x and input wrap
        var div_input = document.createElement('div')
        div_input.id = $name + '__exercise--input'
        div_input.className = $name + '__exercise--input'
        $element.appendChild(div_input)

        // 2x
        var div_sets = document.createElement('div')
        div_sets.id = $name + '__exercise--sets'
        div_sets.className = $name + '__exercise--sets'
        div_sets.innerHTML = '<span id="sets__number" class="sets__number">' + $exercise.sets + '</span>x'
        div_input.appendChild(div_sets)

        // inputs
        for (var i = 0; i < $exercise.sets; i++) {
            var input = document.createElement('input')
            input.id = $name + '__textbox--' + i
            // Don't display inputs for 'Warm up'
            if ($exercise.exercises_id == WARM_UP_ID) {
                input.className = $name + '__textbox hide'
            } else {
                input.className = $name + '__textbox'
            }
            div_input.appendChild(input)
            if (i + 1 < $exercise.sets) {
                var span_plus = document.createElement('span');
                span_plus.className = $name + '__plus'
                span_plus.innerHTML = ' + '
                div_input.appendChild(span_plus)
            }
        }

        // Next button
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

    function addSetHandler(event) {
        // Get the containing div
        var div_input = document.getElementById('input-display__exercise--input')

        // Add a '+'
        var span_plus = document.createElement('span')
        span_plus.className = $name + '__plus'
        span_plus.innerHTML = ' + '
        div_input.appendChild(span_plus)

        // Add the input
        var input = document.createElement('input')
        input.id = $name + '__textbox--' + 'add'
        // Don't display inputs for 'Warm up'
        if ($exercise.exercises_id == WARM_UP_ID) {
            input.className = $name + '__textbox hide'
        } else {
            input.className = $name + '__textbox'
        }
        div_input.appendChild(input)

        // Now update the set number
        var div_sets = document.getElementById('sets__number')
        var sets = parseInt(div_sets.innerHTML) + 1
        div_sets.innerHTML = sets
    }

    function removeSetHandler(event) {
        // Get the containing div
        var div_input = document.getElementById('input-display__exercise--input');

        if (div_input.children.length > 2) {
            // Remove input
            div_input.removeChild(div_input.lastChild)
            // and '+'
            div_input.removeChild(div_input.lastChild)
        }

        // Now update the set number
        var div_sets = document.getElementById('sets__number')
        var sets = parseInt(div_sets.innerHTML) - 1
        if (sets > 0) {
            div_sets.innerHTML = sets
        }
    }

    return {
        init: init,
        next: next
    };
})();
