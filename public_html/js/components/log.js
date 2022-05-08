// public_html/components/log.js
//
//
// Build a list of exercise entries, called the log. This component attaches to
// the element of id = "log"

//let api = "http://workout.local/api/";

var Log = (function() {
    var xhr;

    function buildLog(workouts) {
        log = document.getElementById("log");
        Object.values(workouts).forEach(function (entry) {
            console.log(entry);

            // Wrapper
            var wrap = document.createElement("div");
            wrap.classList = "log__wrap";

            // Workout info: start
            var start = document.createElement("div");
            start.classList = "log__entry"
            start.innerHTML = entry.start;
            wrap.appendChild(start);
            // Workout info: end
            var end = document.createElement("div");
            end.classList = "log__entry"
            end.innerHTML = entry.end;
            wrap.appendChild(end);


            // Exercises
            Object.values(entry.exercises).forEach(function (exercise) {
                var div = document.createElement("div");
                div.classList = "log__exercise";
                var reps = "";
                //console.log(Object.values(exercise.reps).length);
                var count = 0;
                if (exercise.reps == undefined) {
                    reps = " ";
                } else {
                    Object.values(exercise.reps).forEach(function (rep) {
                        reps = reps + rep.amount;
                        if (count < Object.values(exercise.reps).length - 1) {
                            reps = reps + " + ";
                        }
                        count++;
                    })
                }

                div.innerHTML = exercise.exercise_type.title +
                    " --- " + exercise.sets + " X [ "+reps+" ]" +
                    " --- " + exercise.feedback;
                wrap.appendChild(div);
            });

            // Workout info: feel
            var feel = document.createElement("div");
            feel.classList = "log__entry"
            feel.innerHTML = entry.feel;
            wrap.appendChild(feel);
            // Workout info: notes
            var notes = document.createElement("div");
            notes.classList = "log__entry"
            notes.innerHTML = entry.notes;
            wrap.appendChild(notes);

            // div.innerHTML = "<span class=\"log__title\">" +
            //     "<span class=\"fa fa-clock footer__icon\"></span>" +
            //     entry.start +
            //     "</ span> " +
            //     "<a href='/edit/index.php?id=" +
            //     entry.id +
            //     "'>Edit</a>";
            // var button = document.createElement("a");
            // button.classList = "button";
            // button.innerHTML = "Load";
            // div.appendChild(button);
            log.appendChild(wrap);
        });
    }

    function logHandler() {
        buildLog(JSON.parse(this.responseText));
    }

    // Public
    function init() {
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", logHandler);
        xhr.open("GET", api + "workouts");
        xhr.send();
    }

    return {
        init: init
    };
})();
