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
        // Create warm-up item at the top
        var warmupItem = document.createElement('li');
        var warmupSelectList = document.createElement('select');
        list.appendChild(warmupItem);
        warmupItem.appendChild(warmupSelectList);

        var warmupOption = document.createElement('option');
        warmupOption.value = "warmup";
        warmupOption.text = "Warm up";
        warmupSelectList.appendChild(warmupOption);
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

    return {
        init: load
    };
})();
