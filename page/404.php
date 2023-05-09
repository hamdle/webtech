<?php

if (!$this->session->authenticated()) {
    $this->renderOrDie($_ENV["HOME_PAGE"]);
}

$this->title = "404";

?>

<?php $this->tryRenderTemplate('htmlheader.php'); ?>

<div class="dash__body">
    <div class="dash__wrap">

        <?php $this->tryRenderTemplate('pageheader.php'); ?>

        <div class="login-form__wrap">
            <form id="loginForm" class="login__form">
                <h1 class="login__header">Page Not Found</h1>
            </form>
        </div>

    </div><!-- wrap -->

    <?php $this->tryRenderTemplate('authpagefooter.php'); ?>

</div><!-- body -->

<?php $this->tryRenderTemplate('htmlfooter.php'); ?>