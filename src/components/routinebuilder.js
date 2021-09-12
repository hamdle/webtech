/*
 * Workout builder component
 *
 */
var RoutineBuilder = (function() {
    var xhr;
    var $element;

    function load(element) {
        $element = element;
        // Get list of exercises from the Api.
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", exerciseHandler);
        xhr.open("GET", api + 'exercises');
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

    function pop() {
        var list_items = $element.getElementsByTagName('li')
        if (list_items.length === 0) {
            return null
        }

        var select = _pop(list_items)
        if (select === null) {
            return null
        }

        $exercise = {
            name: select.selectedOptions[0].value,
            exercise_type_id: select.selectedOptions[0].getAttribute('data-id'),
            sets: select.selectedOptions[0].getAttribute('data-sets'),
            reps: null,
            feedback: null
        }

        return $exercise

    }

    // Helper functions
    
    // Pop the next exercise off the top of the routine which will
    // delete the element off the page and return it
    function _pop(list_items) {
        var selects = list_items[0].getElementsByTagName('select')
        if (selects.length === 0) {
            return null
        }

        var select = selects[0]

        list_items[0].parentNode.removeChild(list_items[0])

        return select
    }

    // Request handlers.
    function exerciseHandler() {
        if (this.status !== 200) {
            var par = document.createElement('p');
            par.textContent = 'Error loading exercises.';
            $element.appendChild(par);
            return;
        }

        exercises = JSON.parse(this.responseText);
    }

    function addHandler() {
        var listItem = document.createElement('li');
        listItem.classList = 'exercise__list-item';
        var selectList = document.createElement('select');
        selectList.classList = 'exercise__select';

        $element.appendChild(listItem);
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
        if ($element.childNodes.length > 2 &&
            $element.childNodes[$element.childNodes.length-1].nodeName === "LI") {
            $element.removeChild($element.childNodes[$element.childNodes.length-1]);
        }
    }

    return {
        init: load,
        pop: pop
    };
})();
