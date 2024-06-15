<div id="main-content" class="l-site">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--3">
                Workouts
            </h1>
        </div>
    </section>
    <div class="p-stripe is-shallow">
        <div class="row">
            <div class="u-clearfix">
                <div class="u-float-left">
                    <a class="dash__link" href="/go">
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
                    <nav class="p-pagination" aria-label="Pagination">
                        <ol class="p-pagination__items">
                            <li class="p-pagination__item">
                                <span id="page-display" class="p-pagination__display"></span>
                            </li>
                            <li class="p-pagination__item">
                                <a id="prev" class="p-pagination__link--previous" href="#" title="Previous page"><i class="p-icon--chevron-down"></i></a>
                            </li>
                            <li class="p-pagination__item">
                                <a id="next" class="p-pagination__link--next" href="#" title="Next page"><i class="p-icon--chevron-down"></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="log" class="log"></div>
        </div>
    </div>
</div>