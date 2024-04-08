// inputdisplay.js
//
//
// Consume an exercise from the list and provide an interface 
// and display.
//
// include RoutineBuilder
// include Workout
// include Timer

var InputDisplay = (function () {
    var $element;
    var $exercise;
    var $name;
    var $note;
    var $feel;
    var $repInputElements;
    var $cooldown; // in seconds
    var $inputState;
    const WARM_UP_ID = 1;

    function display(option) {
        switch (option) {
            case 'clear':
                clearDisplay();
                break;
            case 'complete':
                showCompleteMessage();
                break;
            case 'failed':
                showFailedMessage();
                break;
            case 'exercise':
                showCurrentExercise();
                break;
            case 'finalize':
                showFinalize();
                break;
        }
    }

    function clearDisplay() {
        while ($element.firstChild) {
            $element.removeChild($element.firstChild)
        }
    }

    function showCompleteMessage() {
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

    function showFailedMessage() {
        var div_finish = document.createElement('div')
        div_finish.id = $name + '__finish--large'
        div_finish.className = $name + '__finish--large'
        div_finish.innerHTML = 'Workout failed'
        $element.appendChild(div_finish)
        var div_finish_small = document.createElement('div')
        div_finish_small.id = $name + '__finish--small'
        div_finish_small.className = $name + '__finish--small'
        div_finish_small.innerHTML = 'Failed to send!'
        $element.appendChild(div_finish_small)
    }

    function showCurrentExercise() {
        // Exercise name
        var div_label = document.createElement('div')
        div_label.id = $name + '__exercise--label'
        div_label.className = $name + '__exercise--label'
        var div_name = document.createElement('div')
        div_name.className = $name + '__exercise--name'
        div_name.innerHTML = $exercise.name
        div_label.appendChild(div_name)

        if ($exercise.exercise_type_id != WARM_UP_ID) {
            var div_label_wrap = document.createElement('div');
            div_label_wrap.className = $name + '-exercise-button__wrap'
            div_label.appendChild(div_label_wrap)
            // 'Add' button.
            var div_label_add = document.createElement('button')
            div_label_add.className = 'p-button'
                + ' button__spacing--right'
            div_label_add.innerHTML = 'Add'
            // Add set handler.
            div_label_add.addEventListener('click', addSetHandler);
            div_label_wrap.appendChild(div_label_add)

            // 'Remove' button.
            var div_label_remove = document.createElement('button')
            div_label_remove.className = 'p-button ' + $name + '-exercise__button--remove'
            div_label_remove.innerHTML = 'Remove'
            // Remove set handler.
            div_label_remove.addEventListener('click', removeSetHandler);
            div_label_wrap.appendChild(div_label_remove)
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
        // TODO: $inputState
        for (var i = 0; i < $exercise.sets; i++) {
            var input = document.createElement('input')
            input.id = $name + '__textbox--' + i
            // Don't display inputs for 'Warm up'
            if ($exercise.exercise_type_id == WARM_UP_ID) {
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
        var next_button_wrap = document.createElement('div')
        next_button_wrap.className = $name + '-next-button__wrap'
        var next_button = document.createElement('button')
        next_button.id = $name + '__next-button'
        //next_button.className = $name + '__next-button'
        next_button.className = 'p-button--positive'
        next_button.innerHTML = 'Next exercise'
        next_button_wrap.appendChild(next_button)
        $element.appendChild(next_button_wrap)

        next_button.addEventListener('click', next);

        $repInputElements = Array.from(div_input.querySelectorAll('input'));

        requestSuggestedReps($exercise.exercise_type_id);
    }

    function requestSuggestedReps(exerciseTypeId) {
        console.log("Requesting suggested reps for exercise " + exerciseTypeId);
        $rpc = {
            "exerciseTypeId": exerciseTypeId,
            "method": "Workout.suggestedReps"
        }
        $xhr = new XMLHttpRequest();
        $xhr.addEventListener("load", suggestRepsHandler);
        $xhr.open("POST", api);
        $xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        $xhr.send(JSON.stringify($rpc));
    }

    function showFinalize() {
        var wrap = document.createElement('div');
        wrap.className = "feedback__wrap";

        var notes = document.createElement('textarea');
        notes.className = "feedback__notes";
        notes.id = "notes";
        notes.rows = 4;
        wrap.appendChild(notes);

        var feel = document.createElement('select');
        feel.className = "feedback__feel";
        feel.id = "feel";
        ['weak','average','strong'].forEach(function (item) {
                var option = document.createElement('option');
                option.value = item;
                option.innerHTML = item;
                feel.appendChild(option);
            }
        );
        wrap.appendChild(feel);
        $element.appendChild(wrap);

        // Save button
        var next_button_wrap = document.createElement('div')
        next_button_wrap.className = $name + '-next-button__wrap'
        var next_button = document.createElement('button')
        next_button.id = $name + '__next-button'
        //next_button.className = $name + '__next-button'
        next_button.className = 'p-button'
        next_button.innerHTML = "<span class=\"fa fa-save exercise__icon\"></span> Save"
        next_button_wrap.appendChild(next_button)
        $element.appendChild(next_button_wrap)

        next_button.addEventListener('click', save);
    }

    // Request handlers
    function addSetHandler(event) {
        // TODO: $inputState
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
        if ($exercise.exercise_type_id == WARM_UP_ID) {
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
        // TODO: $inputState
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

    function suggestRepsHandler() {
        if (this.status === 200) {
            payload = JSON.parse(this.responseText);
            console.log(payload);
            if (payload.ok === "true") {
                var i;
                for (i = 0; i < $repInputElements.length; i++) {
                    if (typeof payload.suggestedReps[i] !== 'undefined') {
                        $repInputElements[i].placeholder = payload.suggestedReps[i];
                    }
                }
            }
        }
    }

    // Public
    function init(element, cooldown) {
        $element = element
        $exercise = null
        $name = 'input-display'
        $cooldown = cooldown;

        // TODO: $inputState

        // Get next exercise
        var rawExercises = localStorage.getItem("workout.exercises");
        if (rawExercises)
        {
            var exercises = JSON.parse(rawExercises);
            var inProgress = localStorage.getItem("workout.exerciseInProgress");
            console.log(exercises);
            for (var exercise of exercises) {
                if (exercise.name == inProgress) {
                    $exercise = exercise;
                }
            }

            // Update input display
            display('clear');

            if ($exercise === null)
            {
                Timer.stop();
                display('finalize');
            } else
            {
                display('exercise');
                //Workout.addExercise($exercise);
                Countdown.start($cooldown)
            }
        }
        else
        {
            localStorage.setItem("inputdisplay.inputState", "");
        }
    }

    function next() {
        // TODO: $inputState
        localStorage.setItem("inputdisplay.inputState", "");
        // Process last exercise
        if ($exercise !== null) {
            var reps = []
            inputs = $element.getElementsByTagName('input')

            for (var n = 0; n < inputs.length; n++) {
                var rep = {
                    amount: (inputs[n].value ? inputs[n].value : 1)
                };
                
                reps.push(rep)
            }

            $exercise['reps'] = reps
            $exercise['sets'] = inputs.length
        }

        // Get next exercise
        $exercise = RoutineBuilder.pop()

        // Update input display
        display('clear');

        if ($exercise === null) {
            Timer.stop();
            display('finalize');
        } else {
            display('exercise');
            Workout.addExercise($exercise);
            Countdown.start($cooldown)
        }
    }

    function save() {
        // Process note and feel
        $note = document.getElementById('notes').value;
        $feel = document.getElementById('feel').value;

        display('clear');

        // Set, save, and send...
        Workout.addNote($note);
        Workout.addFeel($feel);
        Workout.completeAndSend(function () {
                window.onbeforeunload = function () {
                    // Left empty to remove leave page warning
                };
                display('complete');
            },
            function () {
                display('failed');
            });
    }

    return {
        init: init,
        next: next
    };
})();
