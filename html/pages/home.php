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
    <div class="p-stripe is-shallow">
        <div class="row">
            <div class="p-card">
                <a class="dash__link" href="/go">
                    <div class="p-button has-icon">
                        <i class="p-icon--plus"></i>
                        <span>Start New Workout</span>
                    </div>
                </a>
            </div>
            <div class="p-card">
                <div class="dash__display">
                    <div class="dash__body">
                        <?php
                        $results = \Core\Database::execute('total-workouts.sql', [
                            'user_id' => $App->User->id
                        ]);
                        $totalWorkouts = $results[0]['total'];
                        ?>
                        <div class="analytics__row ">
                            <span class="analytics__title">Total workouts: </span><span class="analytics__result"><?php echo $totalWorkouts ?></span>
                        </div>
                    </div>
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