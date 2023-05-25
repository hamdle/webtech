<?php
$App = $this;
$App->IsAuthenticated();

$App->Attributes["title"] = "User";

$App->RenderHtml('open.php');
$App->RenderHtml('header.php');
?>

<div id="main-content" class="">
    <div class="p-stripe is-shallow">
        <div class="row">
            <div class="p-card u-vertically-center">
                <div class="card">
                    <div class="card u-clearfix">
                        <div class="card u-float-left">
                            <h2>Settings</h2>
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
                            <th>Name</th>
                            <th><?php echo $App->User->first_name; ?></th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th><?php echo $App->User->email; ?></th>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <th><?php echo $App->User->created_date; ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <p class="u-clearfix">
                        <div class="card u-float-left"><button class="p-button">Edit</button></div>
                        <div class="card u-float-right"><button class="p-button--negative">Delete</button></div>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $App->RenderHtml('footer.php'); ?>
<?php $App->RenderHtml('close.php'); ?>