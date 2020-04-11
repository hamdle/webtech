// Workout component
var Workout = (function() {
    var $xhr
    var $workout

    // Class Api.
    function load(user_id) {
        $workout = {
            start_time: null,
            end_time: null,
            exercises: []
        }
    }

    function create() {
        $workout.start_time = new Date().getTime()
    }

    function get() {
        return $workout;
    }

    function complete() {
        $workout.end_time = new Date().getTime()

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
        console.log('exercise ' + exercise.name + ' added.')
        $workout.exercises.push(exercise)
    }

    return {
        init: load,
        create: create,
        get: get,
        complete: complete,
        addExercise: addExercise
    };
})();
