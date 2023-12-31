// Workout
//
//
// Track a workout using a data structure and Json.

var Workout = (function() {
    var $xhr
    var $workout
    var $exerciseInProgress = null;
    var $tab;
    var $icon;

    // Public
    function init(user_id)
    {
        var exercises = localStorage.getItem("workout.exercises");
        $workout = {
            start: localStorage.getItem("workout.start"),
            end: localStorage.getItem("workout.end"),
            notes: localStorage.getItem("workout.notes"),
            feel: localStorage.getItem("workout.feel"),
            exercises: JSON.parse(exercises) ?? []
        }
    }

    function create()
    {
        // As Linux timestamp
        $workout.start = Math.round(+new Date() / 1000);
        localStorage.setItem("workout.start", $workout.start);
        $icon.classList.add("u-animation--spin");
    }

    function get()
    {
        return $workout;
    }

    function clearLocalStorage()
    {
        localStorage.removeItem("workout.exerciseInProgress");
        localStorage.removeItem("workout.exercises");
        localStorage.removeItem("workout.feel");
        localStorage.removeItem("workout.notes");
        localStorage.removeItem("workout.start");
    }

    function completeAndSend(onSuccess, onFailure)
    {
        // Linux timestamp
        $workout.end = Math.round(+new Date() / 1000);
        $workout.method = "Workout.save";

        console.log($workout);
        localStorage.removeItem("workout.exerciseInProgress");

        $xhr = new XMLHttpRequest();
        $xhr.addEventListener('load', function(event) {
            //console.log($xhr.status);
        });
        $xhr.onreadystatechange = function() {
            if ($xhr.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    payload = JSON.parse(this.responseText);
                    if (payload.ok == "true") {
                        clearLocalStorage();
                        $icon.classList.remove("u-animation--spin");
                        $icon.classList.remove("p-icon--spinner");
                        $icon.classList.add("p-icon--success");
                        $tab.innerHTML = "Workout Complete";
                        onSuccess();
                    } else {
                        $icon.classList.remove("u-animation--spin");
                        $icon.classList.remove("p-icon--spinner");
                        $icon.classList.add("p-icon--error");
                        onFailure();
                    }
                }
            }
        }
        $xhr.addEventListener('error', function(event) {
            onFailure();
            console.log('There was an error with this request.');
        });
        $xhr.open("POST", api);
        $xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        // Send as a simple request to avoid preflight CORS policy checks
        //$xhr.setRequestHeader("Content-Type", "text/plain;charset=UTF-8");
        $xhr.send(JSON.stringify($workout));
    }

    function addExercise(exercise)
    {
        $exerciseInProgress = exercise.name;
        $tab.innerHTML = $exerciseInProgress;
        localStorage.setItem("workout.exerciseInProgress", $exerciseInProgress);
        //delete exercise.name
        $workout.exercises.push(exercise)
        localStorage.setItem("workout.exercises", JSON.stringify($workout.exercises));
    }

    function addNote(note) {
        $workout.notes = note;
        localStorage.setItem("workout.notes", $workout.notes);
    }

    function addFeel(feel) {
        $workout.feel = feel
        localStorage.setItem("workout.feel", $workout.feel);
    }

    function tab(element, icon) {
        $tab = element;
        $icon = icon;
    }

    function discard() {
        clearLocalStorage();
    }

    return {
        init: init,
        tab: tab,
        create: create,
        get: get,
        completeAndSend: completeAndSend,
        addExercise: addExercise,
        addNote: addNote,
        addFeel: addFeel,
        discard: discard
    };
})();
