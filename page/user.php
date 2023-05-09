<?php

if (!$this->session->authenticated()) {
    $this->renderOrDie($_ENV["HOME_PAGE"]);
}

$this->title = "User";

?>

<?php $this->tryRenderTemplate('htmlheader.php'); ?>

<div class="dash__body">
    <div class="dash__wrap">

        <?php $this->tryRenderTemplate('pageheader.php'); ?>

        <div id="content" class="dash__display dash__display--log">
            <div class="dash__body">
                <div class="user__field"><span class="fa fa-user user__icon"></span></div>
                <div class="user__field">Name: <span class="user__value"><?php echo $this->session->user->first_name; ?></span></div>
                <div class="user__field">Email: <span class="user__value"><?php echo $this->session->user->email; ?></span></div>
                <div class="user__field">Created on: <span class="user__value"><?php echo $this->session->user->created_date; ?></span></div>
            </div>
        </div>

    </div><!-- wrap -->

    <?php $this->tryRenderTemplate('authpagefooter.php'); ?>

</div><!-- body -->

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>