// Log
//
//
// Build a list of exercise entries, called the log. This component attaches to
// the element of id = "log"

var Log = (function() {
    var $xhr;
    var $prev;
    var $next;
    var $display;
    var $total;
    var $pagination;
    var $page = 1;

    function buildLog(workouts) {
        if (workouts === null) {
            $page--;
            return;
        }
        var log = document.getElementById("log");
        var tempLog = document.createElement("div");

        Object.values(workouts).forEach(function (entry) {
            var wrap = document.createElement("div");
            wrap.classList = "p-card";

            var start = document.createElement("h2");
            start.classList = "log__time"
            var timeParts = entry.start.split("-");
            var time = timeParts[1] + "/" + timeParts[2].split(" ")[0] + "/" + timeParts[0];
            start.innerHTML = "<span class=\"fa fa-running footer__icon log__time__icon\"></span>" +
                "Workout — " + time; // entry.end;
            wrap.appendChild(start);

            var load = document.createElement("button");
            load.textContent = "Load";
            load.classList = "p-button";
            load.setAttribute("data-exercise-ids", "");
            load.addEventListener('click', loadWorkout);
            wrap.appendChild(load);

            var table = document.createElement("table");
            table.classList = "log__table";

            var thead = document.createElement("thead");

            var tr3 = document.createElement("tr");
            tr3.classList = "log__table__row";
            ["Exercise", "Sets", "Reps", ""].forEach(function (x) {
                var td = document.createElement("th")
                td.classList = "log__table__row__header";
                td.textContent = x;
                tr3.appendChild(td);
            });

            thead.appendChild(tr3)
            table.appendChild(thead);

            // Exercises
            var exercise_ids = "";
            Object.values(entry.exercises).forEach(function (exercise) {
                exercise_ids += (exercise_ids === "" ? "" : ",") + exercise.exercise_type_id;
                var reps = "";
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

                var tr2 = document.createElement("tr");
                tr2.classList = "log__table__row log__table__row__data";

                var td1 = document.createElement("th")
                var icon = document.createElement("span");
                icon.classList = "fa fa-dumbbell";
                td1.appendChild(icon);
                td1.classList = "log__table__row__item log__table__row__item-title";
                td1.textContent = exercise.exercise_type.title;
                tr2.appendChild(td1);
                var td2 = document.createElement("td")
                td2.classList = "log__table__row__item";
                td2.textContent = exercise.sets;
                tr2.appendChild(td2);
                var td3 = document.createElement("td")
                td3.classList = "log__table__row__item";
                td3.textContent = "[ " + reps + " ]";
                tr2.appendChild(td3);
                var td4 = document.createElement("td")
                td4.classList = "log__table__row__item";
                td4.textContent = exercise.feedback
                //tr2.appendChild(td4);
                table.appendChild(tr2);
            });
            load.setAttribute("data-exercise-ids", exercise_ids);
            wrap.appendChild(table);

            // Workout info: feel
            var feel = document.createElement("div");
            feel.classList = "log__feel"
            feel.innerHTML = entry.feel;
            wrap.appendChild(feel);

            // Workout info: notes
            var notes = document.createElement("div");
            notes.classList = "log__notes"
            notes.innerHTML = entry.notes.replace(/\n/g, "<br />");
            ;
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

            tempLog.appendChild(wrap);
        });

        log.innerHTML = "";
        var i = 0;
        for (i = tempLog.children.length - 1; i >= 0; i--) {
            log.appendChild(tempLog.children[i])
        }
    }

    function loadWorkout(event) {
        var ids = event.target.getAttribute("data-exercise-ids")
        window.location = "/go?el=" + ids;
    }

    function logHandler(event) {
        const response = JSON.parse(event.target.responseText);
        if (response.ok === 'true') {
            buildLog(response.workouts);
        }
    }

    function onPrevHandler(event) {
        $page--;
        if ($page == 1) {
            $prev.classList.add("is-disabled");
            sendRequest();
        } else if ($page < 1) {
            $page = 1;
        } else {
            $next.classList.remove("is-disabled");
            sendRequest();
        }
    }

    function onNextHandler(event) {
        $page++;
        if ($page == Math.ceil($total / $pagination)) {
            $next.classList.add("is-disabled");
            sendRequest();
        } else if ($page > Math.ceil($total / $pagination)) {
            $page--;
        } else {
            $prev.classList.remove("is-disabled");
            sendRequest();
        }
    }

    function sendRequest() {
        $xhr = new XMLHttpRequest();
        $xhr.addEventListener("load", logHandler);
        $xhr.open("POST", api);
        $xhr.setRequestHeader('Content-type', 'application/json');
        $xhr.send(JSON.stringify({
            method: "Workout.all",
            page: $page
        }));

        $display.innerHTML = $page + " / " + Math.ceil($total / $pagination);
    }

    // Public
    function init(api, prev, next, display, total, pagination) {
        $prev = prev;
        $prev.addEventListener('click', onPrevHandler);
        $next = next;
        $next.addEventListener('click', onNextHandler);
        $display = display;
        $total = total;
        $pagination = pagination;

        $prev.classList.add("is-disabled");
        sendRequest();
    }

    return {
        init: init
    };
})();
