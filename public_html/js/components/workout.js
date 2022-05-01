// public_html/components/workout.js
//
//
// Track a workout using a data structure and Json.

var Workout = (function() {
    var $xhr
    var $workout

    // Public
    function init(user_id)
    {
        $workout = {
            start: null,
            end: null,
            notes: null,
            feel: null,
            exercises: []
        }
    }

    function create()
    {
        // As Linux timestamp
        $workout.start = Math.round(+new Date() / 1000);
    }

    function get()
    {
        return $workout;
    }

    function complete()
    {
        // Linux timestamp
        $workout.end = Math.round(+new Date() / 1000);

        console.log('sending workout request');
        console.log($workout);

        $xhr = new XMLHttpRequest();
        $xhr.addEventListener('load', function(event) {
            //console.log($xhr.status);
        });
        $xhr.onreadystatechange = function() {
            if ($xhr.readyState == XMLHttpRequest.DONE) {
                if (this.status == 201) {
                    console.log("Successful. Response code: "+this.status);
                } else {
                    console.log('Login failed. Response code: '+this.status);
                }
            }
        }
        $xhr.addEventListener('error', function(event) {
            console.log('There was an error with this request.');
        });
        $xhr.open("POST", api + 'workouts/new');

        $xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        // Send as a simple request to avoid preflight CORS policy checks
        //$xhr.setRequestHeader("Content-Type", "text/plain;charset=UTF-8");
        $xhr.send(JSON.stringify($workout));
    }

    function addExercise(exercise)
    {
        console.log('exercise ' + exercise.name + ' added.')
        delete exercise.name
        $workout.exercises.push(exercise)
    }

    return {
        init: init,
        create: create,
        get: get,
        complete: complete,
        addExercise: addExercise
    };
})();
