<div id="main-content" class="">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--1">
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
                        <button class="p-tabs__link" role="tab" aria-selected="false" aria-controls="takepicture-tab" id="takepicture" tabindex="-1">Takepicture</button>
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
                                            <th><?php echo \App\Core\Context::get('user')->first_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Last Name</th>
                                            <th><?php echo \App\Core\Context::get('user')->last_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th><?php echo \App\Core\Context::get('user')->email; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Created On</th>
                                            <th><?php
                                                echo is_null(\App\Core\Context::get('user')->created_date)
                                                    ? ltrim(date("m/d/Y"), "0")
                                                    : (new DateTime(\App\Core\Context::get('user')->created_date))->format("F j, Y"); ?></th>
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
                                            <th><?php echo \App\Core\Database\Database::config("rep_rest_default", \App\Core\Context::get('user')->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Seconds Between Sets</th>
                                            <th><?php echo \App\Core\Database\Database::config("set_rest_default", \App\Core\Context::get('user')->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Workouts Pagination</th>
                                            <th><?php echo \App\Core\Database\Database::config("pagination_default", \App\Core\Context::get('user')->id) ?></th>
                                            <th>User Default</th>
                                        </tr>
                                        <tr>
                                            <th>Play Timer Sound</th>
                                            <th><?php echo \App\Core\Database\Database::config("play_timer_sound", \App\Core\Context::get('user')->id) ?></th>
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

                <div tabindex="0" role="tabpanel" id="takepicture-tab" aria-labelledby="takepicture" hidden="true">
                    <div class="p-stripe is-shallow">
                        <div class="row">
                            <div class="p-card u-vertically-center">
                                <div class="card">
                                    <div class="card u-clearfix">
                                        <div class="card u-float-left">
                                            <h2>Takepicture Settings</h2>
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
                                            <th>Takepicture purge (days):</th>
                                            <th><?php echo \App\Core\Database\Database::config("takepicture_purge_days", \App\Core\Context::get('user')->id) ?></th>
                                            <th>System Default</th>
                                        </tr>
                                        <tr>
                                            <th>Ping purge (days):</th>
                                            <th><?php echo \App\Core\Database\Database::config("ping_purge_days", \App\Core\Context::get('user')->id) ?></th>
                                            <th>System Default</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card">
                                    <p class="u-clearfix">
                                    <div id="edittp" aria-controls="modal" class="card u-float-left"><button class="p-button">Edit</button></div>
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
                                            <th>Timezone:</th>
                                            <th><?php echo \App\Core\Database\Database::config("default_timezone", \App\Core\Context::get('user')->id) ?></th>
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
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="First Name" value="<?php echo \App\Core\Context::get('user')->first_name; ?>" name="first_name" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Last Name:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Last Name" value="<?php echo \App\Core\Context::get('user')->last_name; ?>"  name="last_name" />
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
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Reps (seconds)" value="<?php echo \App\Core\Database\Database::config("rep_rest_default", \App\Core\Context::get('user')->id) ?>" name="rep_rest_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Seconds Between Sets:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Sets (seconds)" value="<?php echo \App\Core\Database\Database::config("set_rest_default", \App\Core\Context::get('user')->id) ?>"  name="set_rest_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Workouts Pagination:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Pagination" value="<?php echo \App\Core\Database\Database::config("pagination_default", \App\Core\Context::get('user')->id) ?>"  name="pagination_default" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Play Timer Sound:</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Play Timer Sound" value="<?php echo \App\Core\Database\Database::config("play_timer_sound", \App\Core\Context::get('user')->id) ?>"  name="play_timer_sound" />
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

<div class="p-modal" id="modaltp" style="display: none;">
    <section class="p-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description">
        <header class="p-modal__header">
            <h2 class="p-modal__title" id="modal-title">Edit Takepicture Settings</h2>
            <button class="p-modal__close" aria-label="Close active modal" aria-controls="modaltp">Close</button>
        </header>
        <form id="takepictureSettingsForm" class="login__form">
            <div class="form-box card selected-login">
                <p class="u-clearfix">
                    <label class="login__title">Takepicture purge (days):</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Takepicture (days)" value="<?php echo \App\Core\Database\Database::config("takepicture_purge_days", \App\Core\Context::get('user')->id) ?>" name="takepicture_purge_days" />
                </p>
                <p class="u-clearfix">
                    <label class="login__title">Ping purge (days):</label>
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Ping (days)" value="<?php echo \App\Core\Database\Database::config("ping_purge_days", \App\Core\Context::get('user')->id) ?>"  name="ping_purge_days" />
                </p>
                <p class="u-clearfix">
                    <input type="hidden" name="method" value="Config.saveTakepictureSettings">
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
                    <input class="input login__input" autocapitalize="off" autocorrect="off" type="text" placeholder="Timezone" value="<?php echo \App\Core\Database\Database::config("default_timezone", \App\Core\Context::get('user')->id) ?>" name="default_timezone" />
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