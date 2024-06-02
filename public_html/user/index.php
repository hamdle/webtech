<?php

use App\Core;
use Api\Core\Database\Database;

require_once dirname(__DIR__, 2) . "/autoload.php";

$App = new Core("User");
$App->renderHtml(Core::HTML_OPEN);
$App->renderHtml(Core::HTML_HEADER);

?>

<div id="main-content" class="">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--3">
                Settings
            </h1>
            <nav class="p-tabs">
                <div class="p-tabs__list" role="tablist" aria-label="Juju technology">
                    <div class="p-tabs__item">
                        <button class="p-tabs__link" role="tab" aria-selected="true" aria-controls="user-tab" id="user">User</button>
                    </div>
                    <div class="p-tabs__item">
                        <button class="p-tabs__link" role="tab" aria-selected="false" aria-controls="workout-tab" id="workout" tabindex="-1">Workout</button>
                    </div>
                    <div class="p-tabs__item">
                        <button class="p-tabs__link" role="tab" aria-selected="false" aria-controls="system-tab" id="system" tabindex="-1">System</button>
                    </div>
                </div>

                <div tabindex="0" role="tabpanel" id="user-tab" aria-labelledby="user">
                    <div class="p-stripe is-shallow">
                        <div class="row">
                            <div class="p-card u-vertically-center">
                                <div class="card">
                                    <div class="card u-clearfix">
                                        <div class="card u-float-left">
                                            <h2>User Settings</h2>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="p-card__content">
                                        <img class="p-card__image" alt="" src="<?php echo $_ENV['ORIGIN']; ?>/img/p-bar.png" height="150">
                                    </div>
                                </div>
                                <div class="card">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>First Name</th>
                                            <th><?php echo $App->user->first_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Last Name</th>
                                            <th><?php echo $App->user->last_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th><?php echo $App->user->email; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Created On</th>
                                            <th><?php
                                                echo is_null($App->user->created_date)
                                                    ? ltrim(date("m/d/Y"), "0")
                                                    : (new DateTime($App->user->created_date))->format("F j, Y"); ?></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card">
                                    <p class="u-clearfix">
                                    <div id="edit" aria-controls="modal" class="card u-float-left"><button class="p-button">Edit</button></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div tabindex="0" role="tabpanel" id="workout-tab" aria-labelledby="workout" hidden="true">
                    <div class="p-stripe is-shallow">
                        <div class="row">
                            <div class="p-card u-vertically-center">
                                <div class="card">
                                    <div class="card u-clearfix">
                                        <div class="card u-float-left">
                                            <h2>Workout Settings</h2>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="p-card__content">
                                        <img class="p-card__image" alt="" src="<?php echo $_ENV['ORIGIN']; ?>/img/p-bar.png" height="150">
                                    </div>
                                </div>
                                <div class="card">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>Seconds Between Reps</th>
                                            <th><?php echo Database::config("rep_rest_default", $App->user->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Seconds Between Sets</th>
                                            <th><?php echo Database::config("set_rest_default", $App->user->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Workouts Pagination</th>
                                            <th><?php echo Database::config("pagination_default", $App->user->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Play Timer Sound</th>
                                            <th><?php echo Database::config("play_timer_sound", $App->user->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card">
                                    <p class="u-clearfix">
                                    <div id="editwo" aria-controls="modal" class="card u-float-left"><button class="p-button">Edit</button></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div tabindex="0" role="tabpanel" id="system-tab" aria-labelledby="system" hidden="true">
                    <div class="p-stripe is-shallow">
                        <div class="row">
                            <div class="p-card u-vertically-center">
                                <div class="card">
                                    <div class="card u-clearfix">
                                        <div class="card u-float-left">
                                            <h2>System Settings</h2>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="p-card__content">
                                        <img class="p-card__image" alt="" src="<?php echo $_ENV['ORIGIN']; ?>/img/p-bar.png" height="150">
                                    </div>
                                </div>
                                <div class="card">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>Timezone</th>
                                            <th><?php echo Database::config("default_timezone", $App->user->id) ?></th>
                                            <th>System Default</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card">
                                    <p class="u-clearfix">
                                    <div id="editsys" aria-controls="modal" class="card u-float-left"><button class="p-button">Edit</button></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

        </div>
    </section>

</div>

<div class="p-modal" id="modal" style="display: none;">
    <section class="p-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description">
        <header class="p-modal__header">
            <h2 class="p-modal__title" id="modal-title">Edit User Settings</h2>
            <button class="p-modal__close" aria-label="Close active modal" aria-controls="modal">Close</button>
        </header>
        <form id="userSettingsForm" class="login__form">
            <div class="form-box card selected-login">
                <p class="u-clearfix">
                    <label class="login__title">First Name:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="First Name" value="<?php echo $App->user->first_name; ?>" name="first_name" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Last Name</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Last Name" value="<?php echo $App->user->last_name; ?>"  name="last_name" />
                </p>
                <p class="u-clearfix">
                    <input type="hidden" name="method" value="Config.saveUserSettings">
                </p>
            </div>
            <footer class="p-modal__footer">
                <button class="u-no-margin--bottom" aria-controls="modal">Cancel</button>
                <button id="login__button" class="button p-button--positive u-no-margin--bottom has-icon" type="submit">
                    <span class="fa fa-save footer__icon login-button__icon" style="margin-right:6px"></span>
                    Save
                </button>
            </footer>
        </form>
    </section>
</div>

<div class="p-modal" id="modalwo" style="display: none;">
    <section class="p-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description">
        <header class="p-modal__header">
            <h2 class="p-modal__title" id="modal-title">Edit Workout Settings</h2>
            <button class="p-modal__close" aria-label="Close active modal" aria-controls="modalwo">Close</button>
        </header>
        <form id="workoutSettingsForm" class="login__form">
            <div class="form-box card selected-login">
                <p class="u-clearfix">
                    <label class="login__title">Seconds Between Reps:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Reps (seconds)" value="<?php echo Database::config("rep_rest_default", $App->user->id) ?>" name="rep_rest_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Seconds Between Sets:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Sets (seconds)" value="<?php echo Database::config("set_rest_default", $App->user->id) ?>"  name="set_rest_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Workouts Pagination:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Pagination" value="<?php echo Database::config("pagination_default", $App->user->id) ?>"  name="pagination_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Play Timer Sound:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Play Timer Sound" value="<?php echo Database::config("play_timer_sound", $App->user->id) ?>"  name="play_timer_sound" />
                </p>
                <p class="u-clearfix">
                    <input type="hidden" name="method" value="Config.saveWorkoutSettings">
                </p>
            </div>
            <footer class="p-modal__footer">
                <button class="u-no-margin--bottom" aria-controls="modalwo">Cancel</button>
                <button id="login__button" class="button p-button--positive u-no-margin--bottom has-icon" type="submit">
                    <span class="fa fa-save footer__icon login-button__icon" style="margin-right:6px"></span>
                    Save
                </button>
            </footer>
        </form>
    </section>
</div>

    <div class="p-modal" id="modalsys" style="display: none;">
        <section class="p-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description">
            <header class="p-modal__header">
                <h2 class="p-modal__title" id="modal-title">Edit System Settings</h2>
                <button class="p-modal__close" aria-label="Close active modal" aria-controls="modalsys">Close</button>
            </header>
            <form id="systemSettingsForm" class="login__form">
                <div class="form-box card selected-login">
                    <p class="u-clearfix">
                        <label class="login__title">Timezone:</label>
                        <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Timezone" value="<?php echo Database::config("default_timezone", $App->user->id) ?>" name="default_timezone" />
                    </p>
                    <p class="u-clearfix">
                        <input type="hidden" name="method" value="Config.saveSystemSettings">
                    </p>
                </div>
                <footer class="p-modal__footer">
                    <button class="u-no-margin--bottom" aria-controls="modalsys">Cancel</button>
                    <button id="login__button" class="button p-button--positive u-no-margin--bottom has-icon" type="submit">
                        <span class="fa fa-save footer__icon login-button__icon" style="margin-right:6px"></span>
                        Save
                    </button>
                </footer>
            </form>
        </section>
    </div>

<?php $App->renderHtml(Core::HTML_FOOTER); ?>

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
                    if (response.ok === 'false' || response.hasOwnProperty('warning') || response.hasOwnProperty('error')) {
                        return;
                    }
                    if (response.ok === 'true') {
                        window.location.reload();
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
        let systemForm = document.getElementById('systemSettingsForm');
        systemForm.addEventListener("submit", function (event)
        {
            event.preventDefault();
            sendData(systemForm);
        });
    });
</script>

<?php $App->renderHtml(Core::HTML_CLOSE); ?>