// Workout component
var Workout = (function() {
    var xhr;
    var workout;

    function load() {
        workout = {
            id: null
        }
    }

    function create() {
        //TODO: Create a new workout using the Api.
    }

    function get() {
        return workout;
    }

    return {
        init: load,
        create: create,
        get: get
    };
})();
