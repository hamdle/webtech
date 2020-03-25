// Workout component
var Workout = (function() {
    var xhr;
    var workout;

    // Class Api.
    function load(user_id) {
        workout = {
            id: null,
            user_id: user_id
        }
    }

    function create() {
        //TODO: Create a new workout using the Api.
        console.log('new workout created.');
    }

    function get() {
        return workout;
    }

    function complete() {
        //TODO: Send completion time.
        console.log('workout complete.');
    }

    function addExercise(exercise) {
        //TODO: Add a completed exercise to the workout.
        console.log('exercise ' + $exercise.name + ' added.');
    }

    return {
        init: load,
        create: create,
        get: get,
        complete: complete,
        addExercise: addExercise
    };
})();
