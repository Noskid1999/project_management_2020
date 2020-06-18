<div class="navbar-expand-lg navbar-toggler-container navbar-light">
    <button class="navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</div>
<nav class="navbar navbar-expand-lg navbar-light sticky-top">

    <?php
    @include("main-navbar.php");
    ?>
</nav>
<div class="position-fixed mobile-nav">
    <div class="navbar-expand sticky-top">
        <div class="nav-container position-relative">
            <a class="navbar-brand" href="#" style="text-align: center;width:100%">
                <img class="web-img" src="public/img/logo/CHFOM logo with Text.png" alt="" style="height: 60px;">
                <img class="mobile-img" src="public/img/logo/CHFOM logo.png" alt="" style="height: 60px;">
            </a>
            <ul class="navbar-nav" style="text-align: right;">
                <?php
                @include("nav-svg.php");
                ?>
            </ul>
        </div>
    </div>
</div>
<div class="side-navbar">
    <?php
    @include("main-navbar.php");
    ?>
</div>

<?php
@include("includes/search-modal.php");
?>