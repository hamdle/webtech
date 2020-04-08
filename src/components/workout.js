// Workout component
var Workout = (function() {
    var $xhr
    var $workout

    // Class Api.
    function load(user_id) {
        $workout = {
            id: null,
            user_id: user_id,
            start_time: null,
            end_time: null,
            exercises: []
        }
    }

    function create() {
        //TODO: Create a new workout using the Api.
        console.log('new workout created.')
        $workout.start_time = new Date().getTime()
        console.log($workout);
    }

    function get() {
        return $workout;
    }

    function complete() {
        //TODO: Send completion time.
        $workout.end_time = new Date().getTime()
        console.log('workout complete.')
        console.log($workout);
    }

    function addExercise(exercise) {
        //TODO: Add a completed exercise to the workout.
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
