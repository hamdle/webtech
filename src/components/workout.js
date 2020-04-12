// Workout component
var Workout = (function() {
    var $xhr
    var $workout

    // Class Api.
    function load(user_id) {
        $workout = {
            start: null,
            end: null,
            notes: null,
            feel: null,
            entries: []
        }
    }

    function create() {
        // Record a linux timestamp.
        $workout.start = Math.round(+new Date() / 1000);
    }

    function get() {
        return $workout;
    }

    function complete() {
        // Record a linux timestamp.
        $workout.end = Math.round(+new Date() / 1000);

        console.log('sending workout request');
        console.log($workout);

        $xhr = new XMLHttpRequest();
        $xhr.addEventListener('load', function(event) {
            console.log(event.target.responseText);
        });
        $xhr.addEventListener('error', function(event) {
            console.log('Error!');
        });
        $xhr.open("POST", siteUrl + 'workouts/new');

        $xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        $xhr.send(JSON.stringify($workout));
    }

    function addExercise(exercise) {
        console.log('exercise ' + exercise.exercises_id + ' added.')
        $workout.entries.push(exercise)
    }

    return {
        init: load,
        create: create,
        get: get,
        complete: complete,
        addExercise: addExercise
    };
})();
