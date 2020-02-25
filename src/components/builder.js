// Workout builder component
var Builder = (function() {
    var xhr;

    function load() {
        // Get list of exercises from the Api.
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", exerciseHandler);
        xhr.open("GET", siteUrl + 'exercises');
        xhr.send();

        // Load button handlers.
        window.addEventListener("load", function() {
            loadAdd();
            loadRemove();
            loadStart();
        });
    }

    function loadAdd() {
        // Create button to add new exercise to the routine.
        var add = document.getElementById('exercise__button--add');
        add.addEventListener('click', addHandler);
    }

    function loadRemove() {
        // Remove exercises from the bottom of the routine..
        var remove = document.getElementById('exercise__button--remove');
        remove.addEventListener('click', removeHandler);
    }

    function loadStart() {
        // Setup Start button handler.
        var start = document.getElementById('start__button');
        start.addEventListener('click', startHandler);
    }

    // Request handlers.
    function exerciseHandler() {
        if (this.status !== 200) {
            var list = document.getElementById('exercise__list');
            var par = document.createElement('p');
            par.textContent = 'Error loading exercises.';
            list.appendChild(par);
            return;
        }

        exercises = JSON.parse(this.responseText);
        console.log(exercises);

        var list = document.getElementById('exercise__list');
        var listItem = document.createElement('li');
        var selectList = document.createElement('select');

        list.appendChild(listItem);
        listItem.appendChild(selectList);

        exercises.forEach(function(item, index) {
            var option = document.createElement('option');
            option.value = item.title;
            option.text = item.title;
            option.setAttribute('data-id', item.id);
            option.setAttribute('data-sets', item.default_sets);
            selectList.appendChild(option);
        });
    }

    function addHandler() {
        var list = document.getElementById('exercise__list');
        var listItem = document.createElement('li');
        var selectList = document.createElement('select');

        list.appendChild(listItem);
        listItem.appendChild(selectList);

        exercises.forEach(function(item, index) {
            var option = document.createElement('option');
            option.value = item.title;
            option.text = item.title;
            option.setAttribute('data-id', item.id);
            option.setAttribute('data-sets', item.default_sets);
            selectList.appendChild(option);
        });
    }

    function removeHandler() {
        var list = document.getElementById('exercise__list');
        if (list.childNodes.length > 2 &&
            list.childNodes[list.childNodes.length-1].nodeName === "LI") {
            list.removeChild(list.childNodes[list.childNodes.length-1]);
        }
    }

    function startHandler() {
        if (window.confirm("Are you ready to start the workout?")) {
            var timer = document.getElementById('timer');
            timer.innerHTML = new Date().getTime();
        }
    }

    return {
        init: load
    };
})();
