// public_html/component/version.js
//
//
// Load the version of the API via an api call

var Version = (function() {
    var xhr;
    var $element;

    // Request handlers
    function exerciseHandler()
    {
        if (this.status !== 200)
        {
            var par = document.createElement('p');
            par.textContent = 'Error loading exercises.';
            $element.appendChild(par);
            return;
        }

        var response = JSON.parse(this.responseText);
        var dom = document.getElementById('version');
        dom.textContent = response.version;
    }

    // Public
    function init(element)
    {
        $element = element;
        xhr = new XMLHttpRequest();
        xhr.addEventListener("load", exerciseHandler);
        xhr.open("GET", api + 'version');
        xhr.send();
    }

    return {
        init: init,
    };
})();
