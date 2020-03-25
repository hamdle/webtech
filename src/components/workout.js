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
    }

    function get() {
        return workout;
    }

    function complete() {
        //TODO: Send completion time.
        console.log('complete.');
    }

    return {
        init: load,
        create: create,
        get: get,
        complete: complete
    };
})();
