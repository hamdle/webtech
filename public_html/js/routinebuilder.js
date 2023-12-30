// RoutineBuilder
//
//
// Load exercises for the user to select.

var RoutineBuilder = (function() {
    var $xhr;
    var $element;
    var $routine;       // object with routine built by user
    var $orderId;       // order of the exercise in the routine, also used as an id
    var $exercises;     // available exercise types
    var $preload;       // Load button pressed on workout page sent via GET

    // Create button to add new exercise to the routine
    function loadAdd()
    {
        var add = document.getElementById('exercise__button--add');
        add.addEventListener('click', addHandler);
    }

    // Remove exercises from the bottom of the routine
    function loadRemove()
    {
        var remove = document.getElementById('exercise__button--remove');
        remove.addEventListener('click', removeHandler);
    }

    // Pop the next exercise off the top of the routine which will
    // delete the element off the page and return it
    function _pop(list_items)
    {
        var selects = list_items[0].getElementsByTagName('select')
        if (selects.length === 0)
            return null

        var select = selects[0]

        list_items[0].parentNode.removeChild(list_items[0])

        return select
    }

    // Request handlers
    function exerciseHandler(event) {
        const response = JSON.parse(event.target.responseText);
        if (response.ok === 'true') {
            $exercises = response.exercise_types;
            loadAdd();
            loadRemove();
            if ($preload) {
                for (var i = 0; i < $preload.length; i++) {
                    var exists = $exercises.some(function(e) {
                        return e.id == $preload[i];
                    });
                    if (exists) {
                        addHandler($preload[i]);
                    }
                }
            } else {
                var routine = localStorage.getItem("routinebuilder.exercises");
                routine = JSON.parse(routine);
                if (routine)
                {
                    Object.keys(routine).forEach(function(key) {
                        var value = routine[key];
                        addHandler(value);
                    });
                }
            }
        }
    }

    function addHandler() {
        var id = parseInt(arguments[0]);
        var listItem = document.createElement('li');
        listItem.classList = 'exercise__list-item';
        var selectList = document.createElement('select');
        selectList.classList = 'exercise__select';
        selectList.addEventListener("change", selectChangeHandler);
        selectList.setAttribute("data-order-id", ++$orderId);

        $element.appendChild(listItem);
        listItem.appendChild(selectList);

        $exercises.forEach(function(item, index) {
            var option = document.createElement('option');
            option.value = item.title;
            option.text = item.title;
            option.setAttribute('data-id', item.id);
            option.setAttribute('data-sets', item.default_sets);
            if (id === item.id) {
                option.selected = true;
            }
            selectList.appendChild(option);
        });
        $routine[$orderId] = isNaN(+id) ? 1 : id;
        localStorage.setItem("routinebuilder.exercises", JSON.stringify($routine));
    }

    function removeHandler() {
        var $removedOrderId;
        if ($element.childNodes.length > 2 &&
            $element.childNodes[$element.childNodes.length-1].nodeName === "LI") {
            var $select = $element.childNodes[$element.childNodes.length-1].querySelector("select");
            $removedOrderId = $select.getAttribute("data-order-id");
            $element.removeChild($element.childNodes[$element.childNodes.length-1]);
        }
        delete $routine[$removedOrderId];
        localStorage.setItem("routinebuilder.exercises", JSON.stringify($routine));
    }

    function selectChangeHandler(event) {
        var select = event.target;
        var selectedValue = select.value;
        var exercise = $exercises.find(function(item) { return item.title === selectedValue});
        var orderId = select.getAttribute("data-order-id");
        $routine[orderId] = exercise.id;
        localStorage.setItem("routinebuilder.exercises", JSON.stringify($routine));
    }

    // Public
    function init(element, ids) {
        $element = element;
        $preload = ids;
        $routine = {};
        $orderId = 0;

        // Get list of exercises from the Api.
        $xhr = new XMLHttpRequest();
        $xhr.addEventListener("load", exerciseHandler);
        $xhr.open("POST", api);
        $xhr.setRequestHeader('Content-type', 'application/json');
        $xhr.send(JSON.stringify({
            method: "Workout.exerciseTypes"
        }));
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

        $removedOrderId = select.getAttribute("data-order-id");
        delete $routine[$removedOrderId];
        localStorage.setItem("routinebuilder.exercises", JSON.stringify($routine));

        return $exercise
    }

    return {
        init: init,
        pop: pop
    };
})();
