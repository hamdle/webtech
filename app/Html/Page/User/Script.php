<script>
    (function () {
        var keys = {
            left: 'ArrowLeft',
            right: 'ArrowRight',
        };

        var direction = {
            ArrowLeft: -1,
            ArrowRight: 1,
        };

        /**
         Attaches a number of events that each trigger
         the reveal of the chosen tab content
         @param {Array} tabs an array of tabs within a container
         */
        function attachEvents(tabs) {
            tabs.forEach(function (tab, index) {
                tab.addEventListener('keyup', function (e) {
                    if (e.code === keys.left || e.code === keys.right) {
                        switchTabOnArrowPress(e, tabs);
                    }
                });

                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    setActiveTab(tab, tabs);
                });

                tab.addEventListener('focus', function () {
                    setActiveTab(tab, tabs);
                });

                tab.index = index;
            });
        }

        /**
         Determine which tab to show when an arrow key is pressed
         @param {KeyboardEvent} event
         @param {Array} tabs an array of tabs within a container
         */
        function switchTabOnArrowPress(event, tabs) {
            var pressed = event.code;

            if (direction[pressed]) {
                var target = event.target;
                if (target.index !== undefined) {
                    if (tabs[target.index + direction[pressed]]) {
                        tabs[target.index + direction[pressed]].focus();
                    } else if (pressed === keys.left) {
                        tabs[tabs.length - 1].focus();
                    } else if (pressed === keys.right) {
                        tabs[0].focus();
                    }
                }
            }
        }

        /**
         Cycles through an array of tab elements and ensures
         only the target tab and its content are selected
         @param {HTMLElement} tab the tab whose content will be shown
         @param {Array} tabs an array of tabs within a container
         */
        function setActiveTab(tab, tabs) {
            tabs.forEach(function (tabElement) {
                var tabContent = document.getElementById(tabElement.getAttribute('aria-controls'));

                if (tabElement === tab) {
                    tabElement.setAttribute('aria-selected', true);
                    tabContent.removeAttribute('hidden');
                } else {
                    tabElement.setAttribute('aria-selected', false);
                    tabContent.setAttribute('hidden', true);
                }
            });
        }

        /**
         Attaches events to tab links within a given parent element,
         and sets the active tab if the current hash matches the id
         of an element controlled by a tab link
         @param {String} selector class name of the element
          containing the tabs we want to attach events to
         */
        function initTabs(selector) {
            var tabContainers = [].slice.call(document.querySelectorAll(selector));

            tabContainers.forEach(function (tabContainer) {
                var tabs = [].slice.call(tabContainer.querySelectorAll('[aria-controls]'));
                attachEvents(tabs);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initTabs('[role="tablist"]');
        });
    })();
</script>

<script>
    // This is an example modal implementation inspired by
    // https://www.w3.org/TR/wai-aria-practices/examples/dialog-modal/dialog.html

    (function () {
        var currentDialog = null;
        var lastFocus = null;
        var ignoreFocusChanges = false;
        var focusAfterClose = null;

        // Traps the focus within the currently open modal dialog
        function trapFocus(event) {
            if (ignoreFocusChanges) return;

            if (currentDialog.contains(event.target)) {
                lastFocus = event.target;
            } else {
                focusFirstDescendant(currentDialog);
                if (lastFocus == document.activeElement) {
                    focusLastDescendant(currentDialog);
                }
                lastFocus = document.activeElement;
            }
        }

        // Attempts to focus given element
        function attemptFocus(child) {
            if (child.focus) {
                ignoreFocusChanges = true;
                child.focus();
                ignoreFocusChanges = false;
                return document.activeElement === child;
            }

            return false;
        }

        // Focuses first child element
        function focusFirstDescendant(element) {
            for (var i = 0; i < element.childNodes.length; i++) {
                var child = element.childNodes[i];
                if (attemptFocus(child) || focusFirstDescendant(child)) {
                    return true;
                }
            }
            return false;
        }

        // Focuses last child element
        function focusLastDescendant(element) {
            for (var i = element.childNodes.length - 1; i >= 0; i--) {
                var child = element.childNodes[i];
                if (attemptFocus(child) || focusLastDescendant(child)) {
                    return true;
                }
            }
            return false;
        }

        /**
         Toggles visibility of modal dialog.
         @param {HTMLElement} modal Modal dialog to show or hide.
         @param {HTMLElement} sourceEl Element that triggered toggling modal
         @param {Boolean} open If defined as `true` modal will be opened, if `false` modal will be closed, undefined toggles current visibility.
         */
        function toggleModal(modal, sourceEl, open) {
            if (modal && modal.classList.contains('p-modal')) {
                if (typeof open === 'undefined') {
                    open = modal.style.display === 'none';
                }

                if (open) {
                    currentDialog = modal;
                    modal.style.display = 'flex';
                    focusFirstDescendant(modal);
                    focusAfterClose = sourceEl;
                    document.addEventListener('focus', trapFocus, true);
                } else {
                    modal.style.display = 'none';
                    if (focusAfterClose && focusAfterClose.focus) {
                        focusAfterClose.focus();
                    }
                    document.removeEventListener('focus', trapFocus, true);
                    currentDialog = null;
                }
            }
        }

        // Find and hide all modals on the page
        function closeModals() {
            var modals = [].slice.apply(document.querySelectorAll('.p-modal'));
            modals.forEach(function (modal) {
                toggleModal(modal, false, false);
            });
        }

        // Add click handler for clicks on elements with aria-controls
        document.addEventListener('click', function (event) {
            var targetControls = event.target.getAttribute('aria-controls');
            if (targetControls) {
                toggleModal(document.getElementById(targetControls), event.target);
            }
        });

        // Add handler for closing modals using ESC key.
        document.addEventListener('keydown', function (e) {
            e = e || window.event;

            if (e.code === 'Escape') {
                closeModals();
            } else if (e.keyCode === 27) {
                closeModals();
            }
        });

        var edit = document.getElementById("edit");
        edit.addEventListener('click', function (event) {
            toggleModal(document.querySelector('#modal'), document.querySelector('[aria-controls=modal]'), true);
        });
        var edit2 = document.getElementById("editwo");
        edit2.addEventListener('click', function (event) {
            toggleModal(document.querySelector('#modalwo'), document.querySelector('[aria-controls=modalwo]'), true);
        });
        var edit4 = document.getElementById("edittp");
        edit4.addEventListener('click', function (event) {
            toggleModal(document.querySelector('#modaltp'), document.querySelector('[aria-controls=modaltp]'), true);
        });
        var edit3 = document.getElementById("editsys");
        edit3.addEventListener('click', function (event) {
            toggleModal(document.querySelector('#modalsys'), document.querySelector('[aria-controls=modalsys]'), true);
        });
    })();
</script>

<script>
    window.addEventListener("load", function()
    {
        function sendData(form)
        {
            const $xhr = new XMLHttpRequest();
            const formData = new FormData(form);

            $xhr.addEventListener('load', function(event)
            {
                const response = JSON.parse(event.target.responseText);
                if (response.ok === 'false' || response.warning === 'validation failed')
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
                    if (response.ok === 'false' || response.hasOwnProperty('warning') ||
                        (response.hasOwnProperty('error') && response.error === 'true')) {
                        console.log('An error occurred saving data');
                        return;
                    }
                    if (response.ok === 'true') {
                        window.location.reload();
                    }
                }
            });
            $xhr.addEventListener('error', function(event)
            {
                console.log('An error occurred while saving data');
            });
            $xhr.open("POST", api);
            // Specifying a header here could cause the POST data to be sent
            // incorrectly, don't set it explicitly and let the browser generate
            // the correct one automatically
            $xhr.send(formData);
        }

        let form = document.getElementById('userSettingsForm');
        form.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData(form);
        });
        let workoutForm = document.getElementById('workoutSettingsForm');
        workoutForm.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData(workoutForm);
        });
        let takepictureForm = document.getElementById('takepictureSettingsForm');
        takepictureForm.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData(takepictureForm);
        });
        let systemForm = document.getElementById('systemSettingsForm');
        systemForm.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData(systemForm);
        });
    });
</script>