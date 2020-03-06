// Workout component
var Workout = (function() {
    var xhr;
    var id;

    function load() {
        id = null;
        console.log(id);
    }

    function getWorkout() {
        //TODO: Create a new workout using the Api.
        console.log('start workout');
    }

    return {
        init: load,
        start: getWorkout
    };
})();
