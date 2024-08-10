<div id="main-content" class="l-site">
    <section class="p-strip is-shallow u-no-padding--bottom">
        <div class="u-fixed-width">
            <h1 class="p-heading--1">
                Takepicture
            </h1>
        </div>
    </section>
    <div class="p-stripe is-shallow">
        <div class="row">
            <div class="u-clearfix">
                <div class="u-float-left">
                    <a class="dash__link" href="/takepicture/delete">
                        <button class="p-button--negative p-tooltip--top-center" aria-describedby="btn-new-workout">
                            Delete
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >All</span>
                        </button>
                    </a>
                    <a class="dash__link" href="/takepicture/clean">
                        <button class="p-button--negative p-tooltip--top-center" aria-describedby="btn-new-workout">
                            Clean
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >Only keep today</span>
                        </button>
                    </a>

                </div>
                <div class="u-float-right">
                    <a class="dash__link" href="/takepicture">
                        <button class="p-button--positive p-tooltip--top-center" aria-describedby="btm-cntr">
                            <?php
                            $output = shell_exec("ls | wc -l");
                            $totalTakepictures = (int) $output - 1;
                            echo $totalTakepictures;
                            \App\Core\Context::set('total-takepictures', $totalTakepictures);
                            ?>
                            <span class="p-tooltip__message" role="tooltip" id="btm-cntr" >Total pictures</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
                $controller = new \App\Controller\PictureController();
                $list = $controller->list();
            ?>
            <table class="log__table">
                <thead>
                <tr class="log__table__row">
                    <th class="log__table__row__header">Picture</th>
                </tr>
                </thead>
                <?php foreach ($list as $picture) { ?>
                    <tr class="log__table__row log__table__row__data">
                        <td class="log__table__row__item">
                            <a href="<?php echo getenv("ORIGIN") . "/takepicture/" . $picture ?>">
                                <?php echo $picture ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>





    </div>
</div>