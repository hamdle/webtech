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
            //console.log(entry);

            // Wrapper
            var wrap = document.createElement("div");
            wrap.classList = "log__wrap";

            // Workout info: time (end - start)
            var start = document.createElement("div");
            start.classList = "log__time"
            var timeParts = entry.start.split("-");
            var time = timeParts[1] + " - " + timeParts[2].split(" ")[0];
            start.innerHTML = "<span class=\"fa fa-running footer__icon log__time__icon\"></span>" +
                "Workout on " + time; // entry.end;
            wrap.appendChild(start);

            // Exercises
            Object.values(entry.exercises).forEach(function (exercise) {
                var table = document.createElement("table");
                table.classList = "log__table";

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

                var tr1 = document.createElement("tr");
                tr1.classList = "log__table__row";

                var td1 = document.createElement("th")
                var icon = document.createElement("span");
                icon.classList = "fa fa-dumbbell";
                td1.appendChild(icon);
                td1.classList = "log__table__row__header log__table__row__header-title";
                td1.textContent = exercise.exercise_type.title;
                tr1.appendChild(td1);
                table.appendChild(tr1);


                var tr3 = document.createElement("tr");
                tr3.classList = "log__table__row";
                ["Sets", "Reps", "Feedback"].forEach(function (x) {
                    var td = document.createElement("th")
                    td.classList = "log__table__row__header";
                    td.textContent = x;
                    tr3.appendChild(td);
                });

                table.appendChild(tr3);


                var tr2 = document.createElement("tr");
                tr2.classList = "log__table__row";
                var td2 = document.createElement("td")
                td2.classList = "log__table__row__header";
                td2.textContent = exercise.sets;
                tr2.appendChild(td2);
                var td3 = document.createElement("td")
                td3.classList = "log__table__row__header";
                td3.textContent = "[ "+reps+" ]";
                tr2.appendChild(td3);
                var td4 = document.createElement("td")
                td4.classList = "log__table__row__header";
                td4.textContent = exercise.feedback
                tr2.appendChild(td4);
                table.appendChild(tr2);

                // var tr3 = document.createElement("tr");
                // tr3.classList = "log__table__row";
                // var td5 = document.createElement("td")
                // table.appendChild(tr3);

                // div.innerHTML = exercise.exercise_type.title +
                //     " --- " + exercise.sets + " X [ "+reps+" ]" +
                //     " --- " + exercise.feedback;
                // wrap.appendChild(div);
                wrap.appendChild(table);
            });




            // Workout info: feel
            var feel = document.createElement("div");
            feel.classList = "log__feel"
            feel.innerHTML = entry.feel;
            wrap.appendChild(feel);

            // Workout info: notes
            var notes = document.createElement("div");
            notes.classList = "log__notes"
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
