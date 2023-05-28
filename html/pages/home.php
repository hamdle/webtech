<?php
$App = $this;
$App->IsAuthenticated();

$App->Attributes["title"] = "Dashboard";
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
                Workouts
            </h1>
        </div>
    </section>
    <div class="p-stripe is-shallow">
        <div class="row">
            <a class="dash__link" href="/go">
                <div class="p-button has-icon">
                    <i class="p-icon--plus"></i>
                    <span>New</span>
                </div>
                <div class="p-button has-icon">
                    <i class="p-icon--plus"></i>
                    <span>Planned</span>
                </div>
                <div class="p-button has-icon">
                    <i class="p-icon--plus"></i>
                    <span>Custom</span>
                </div>
            </a>
            <div class="">
                <?php
                $results = \Core\Database::execute('total-workouts.sql', [
                    'user_id' => $App->User->id
                ]);
                $totalWorkouts = $results[0]['total'];
                ?>
                <div class="analytics__row ">
                    <h3><span class="analytics__title">Total workouts: </span><span class="analytics__result"><?php echo $totalWorkouts ?></span></h3>
                </div>
            </div>
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