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
                    Develop
                </h1>
                <nav class="p-tabs" aria-label="Example tabs navigation">
                    <ul class="p-tabs__list u-float-right u-no-margin--bottom" role="tablist">
                        <li class="p-tabs__item" role="presentation">
                            <a data-tour="listing-intro" href="#ready" class="p-tabs__link" tabindex="0" role="tab" aria-selected="true">
                                Build
                            </a>
                        </li>
                        <li class="p-tabs__item" role="presentation">
                            <a data-tour="listing-intro" href="#ready" class="p-tabs__link" tabindex="0" role="tab">
                                Weekly Plan
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
        <div class="p-strip is-shallow">
            <div class="row">
                <div class="col-3">
                    <nav class="p-side-navigation" aria-label="Example side navigation">
                        <ul class="p-side-navigation__list">
                            <li class="p-side-navigation__item">
                                <a class="p-side-navigation__link" href="#publicise" aria-current="page">Workouts</a>
                            </li>
                            <li class="p-side-navigation__item">
                                <a class="p-side-navigation__link" href="#publicise/badges">Exercises</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="col-9">

                    <div class="row">
                        <h4>Promote your snap using Snap Store badges</h4>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="select-language">Language:</label>
                        </div>
                        <div class="col-7">
                            <form class="p-form--inline js-language-select">
                                <select id="select-language" name="language">
                                    <option value="de">Deutsch</option>
                                    <option value="en" selected="">English</option>
                                    <option value="es">Español</option>
                                    <option value="fr">Français</option>
                                    <option value="it">Italiano</option>
                                    <option value="jp">日本語</option>
                                    <option value="pl">Polski</option>
                                    <option value="pt">Português</option>
                                    <option value="ru">русский язык</option>
                                    <option value="tw">中文（台灣）</option>
                                </select>
                            </form>
                            <p>You can help translate these buttons <a href="#" target="_blank">in this repository</a>.</p>
                        </div>
                    </div>

                    <div class="row">
                        <hr>
                    </div>

                    <div id="en_content" class="js-language-content">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-5">
                                        <p class="snapcraft-publicise__images">

                                            <a href="#">
                                                <img alt="Get it from the Snap Store" src="https://assets.ubuntu.com/v1/03dad919-%5BEN%5D-snap-store-black-uneditable.svg">
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <label>HTML:</label>
                            </div>
                            <div class="col-7">
              <pre><code id="snippet-en-black-html0">&lt;a href="https://snapcraft.io/my-awesome-snap"&gt;
  &lt;img alt="Get it from the Snap Store" src="https://snapcraft.io/static/images/badges/en/snap-store-black.svg" /&gt;
&lt;/a&gt;</code></pre>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <label>Markdown:</label>
                            </div>
                            <div class="col-7">
                                <pre><code id="snippet-en-black-md0">[![Get it from the Snap Store](https://snapcraft.io/static/images/badges/en/snap-store-black.svg)](https://snapcraft.io/my-awesome-snap)</code></pre>
                            </div>
                        </div>

                        <div class="row">
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-5">
                                        <p class="snapcraft-publicise__images">

                                            <a href="#">
                                                <img alt="Get it from the Snap Store" src="https://assets.ubuntu.com/v1/fa3c60f8-%5BEN%5D-snap-store-white-uneditable.svg">
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <label>HTML:</label>
                            </div>
                            <div class="col-7">
              <pre><code id="snippet-en-black-html1">&lt;a href="https://snapcraft.io/my-awesome-snap"&gt;
  &lt;img alt="Get it from the Snap Store" src="https://snapcraft.io/static/images/badges/en/snap-store-white.svg" /&gt;
&lt;/a&gt;</code></pre>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <label>Markdown:</label>
                            </div>
                            <div class="col-7">
                                <pre><code id="snippet-en-black-md1">[![Get it from the Snap Store](https://snapcraft.io/static/images/badges/en/snap-store-white.svg)](https://snapcraft.io/my-awesome-snap)</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            Download all:
                        </div>
                        <div class="col-7">
                            <a href="#" class="p-button">zip</a>
                            <a href="#" class="p-button">tar.gz</a>
                            <a href="#" target="_blank">View image licence</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>

<?php $App->RenderHtml('footer.php'); ?>

<?php $App->RenderHtml('close.php'); ?>