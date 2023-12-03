<?php

use app\Core;

include dirname(__DIR__, 2) . "/app/Core.php";

$App = new Core();

$App->AuthOrDie();

$App->Attributes["title"] = "404";

$this->RenderHtml('open.php');
$this->RenderHtml('header.php');
?>

    <div id="main-content" class="">
        <section class="p-strip--dark p-cip-hero is-shallow">
            <div class="row">
                <div class="col-12">
                    <h1 class="u-no-margin--bottom" style="max-width: 100%">
                        404
                    </h1>
                </div>
            </div>
        </section>
        <div class="p-stripe is-shallow">
            <div class="row">
                <h2>Page not found</h2>
            </div>
        </div>
        <div class="" style="padding-bottom: 300px;"></div>
    </div>

<?php $App->RenderHtml('footer.php'); ?>
<?php $App->RenderHtml('close.php'); ?>