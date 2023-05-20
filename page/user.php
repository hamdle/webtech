<?php

if (!$this->session->authenticated()) {
    $this->renderOrDie($_ENV["HOME_PAGE"]);
}

$this->title = "User";

?>
<?php $this->tryRenderTemplate('htmlheader.php'); ?>

<?php $this->tryRenderTemplate('vpageheader.php'); ?>

<div id="main-content" class="l-site">
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
                            <th><?php echo $this->session->user->first_name; ?></th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th><?php echo $this->session->user->email; ?></th>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <th><?php echo $this->session->user->created_date; ?></th>
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

    <?php $this->tryRenderTemplate('vauthpagefooter.php'); ?>

</div><!-- main-content -->

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>