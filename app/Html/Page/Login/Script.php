<script>
    window.addEventListener("load", function()
    {
        function sendData()
        {
            const $xhr = new XMLHttpRequest();
            const formData = new FormData(form);

            $xhr.addEventListener('load', function(event)
            {
                const response = JSON.parse(event.target.responseText);
                if (response.ok === 'false' || response.warning === 'login failed')
                {
                    let notification = document.getElementById('notification');
                    if (notification) {
                        notification.classList.remove('u-hide');
                    }
                }
            });
            $xhr.addEventListener('readystatechange', function(event)
            {
                if ($xhr.readyState == XMLHttpRequest.DONE)
                {
                    const response = JSON.parse(event.target.responseText);
                    if (response.ok === 'false' || response.hasOwnProperty('warning') || response.hasOwnProperty('error')) {
                        return;
                    }
                    if (response.ok === 'true') {
                        window.location = site + 'home';
                    }
                }
            });
            $xhr.addEventListener('error', function(event)
            {
                console.log('An error occurred while logging in.');
            });
            $xhr.open("POST", api);
            // Specifying a header here could cause the POST data to be sent
            // incorrectly, don't set it explicitly and let the browser generate
            // the correct one automatically
            $xhr.send(formData);
        }

        let form = document.getElementById('loginForm');
        form.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData();
        });
    });
</script>

<script>
    var closeButtons = document.querySelectorAll('.p-notification__close');

    function setupCloseButton(closeButton) {
        closeButton.addEventListener('click', function(event) {
            var target = event.target.getAttribute('aria-controls');
            var notification = document.getElementById(target);

            if (notification)
            {
                notification.classList.add('u-hide');
            }
        });
    }

    for (var i = 0, l = closeButtons.length; i < l; i++)
    {
        setupCloseButton(closeButtons[i]);
    }
</script>