<div id="main-content" class="l-site">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--3">
                Dashboard
            </h1>
        </div>
    </section>
    <div class="p-stripe is-shallow">
        <div class="row">
            <h4>Workout</h4>
            <p>This is a section for workout</p>
            <div class="u-clearfix">
                <div class="u-float-left">
                    <a class="dash__link" href="/workout/go">
                        <button class="p-tooltip--top-center has-icon" aria-describedby="btn-new-workout">
                            <i class="p-icon--plus"></i>
                            New Workout
                        </button>
                        <button class="p-button--positive p-tooltip--top-center has-icon" aria-describedby="btm-cntr">
                            <i class="p-icon--success"></i>
                            <?php
                            $results = \App\Core\Database\Database::execute('total-workouts.sql', [
                                'user_id' => \App\Core\Context::get('user')->fields["id"]
                            ]);
                            $totalWorkouts = $results[0]['total'];
                            echo $totalWorkouts;
                            \App\Core\Context::set('total-workouts', $totalWorkouts);
                            ?>
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >Completed Workouts</span>
                        </button>
                    </a>
                </div>
                <div class="u-float-right">

                </div>
            </div>
        </div>
        <div class="row">
            <h4>Takepicture</h4>
            <p>This is a section for takepicture</p>
        </div>
        <div class="row">
            <h4>Timelog</h4>
            <p>This is a section for timelog</p>
        </div>
        <div class="row">
            <h4>Ping</h4>
            <p>This is a section for ping</p>
        </div>
    </div>
</div>