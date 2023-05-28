<?php
$App = $this;
$App->IsAuthenticated();

$App->Attributes["title"] = "Plan";
$App->Attributes["menu"] = [
    "Workouts" => "/workouts",
    "Exercises" => "/exercises"
];

$App->RenderHtml('open.php');
$App->RenderHtml('header.php');
?>

    <div id="main-content" class="l-site">
        <section class="p-strip is-shallow u-no-padding--bottom">
            <div class="u-fixed-width">
                <h1 class="p-heading--3">
                    Metrics
                </h1>
            </div>
        </section>
        <div class="p-stripe is-shallow">
            <div class="row">
                <div class="p-card">
                    <div id="log" class="log"></div>
                </div>
            </div>
        </div>
    </div>

<?php $App->RenderHtml('footer.php'); ?>

    <script src="<?php echo $_ENV['ORIGIN']; ?>/js/log.js"></script>
    <script>
        Log.init(api);
    </script>

<?php $App->RenderHtml('close.php'); ?>