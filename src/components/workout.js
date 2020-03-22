// Workout component
var Workout = (function() {
    var xhr;
    var workout;

    function load() {
        workout = {
            id: null
        }
    }

    function getWorkout() {
        //TODO: Create a new workout using the Api.
        return workout;
    }

    return {
        init: load,
        start: getWorkout
    };
})();
