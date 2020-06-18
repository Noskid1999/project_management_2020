<div class="collapse navbar-collapse justify-content-center mx-auto" id="navbarData">
    <a href="#" style="position: absolute;top:10px;left:30px;font-size: 2rem;">
        <i class="fas fa-times close-sidebar"></i>
    </a>
    <a class="navbar-brand" href="/" style="text-align: left;width:50%">
        <img src="public/img/logo/CHFOM logo with Text.png" alt="" style="height: 60px;">
    </a>
    <ul class="navbar-nav mt-2 mt-lg-0" style="text-align: center;width:70%">
        <li class="nav-item">
            <a class="nav-link nav-text" href="/index.php">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-text" href="/shop.php">SHOP</a>
        </li>

        <li class="nav-item">
            <a class="nav-link nav-text" href="/customer-profile.php">PROFILE</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-text" href="/about-us.php">ABOUT US</a>
        </li>
    </ul>
    <ul class="navbar-nav mt-2 mt-lg-0 navbar-icons" style="text-align: right;">
        <?php
        @include("nav-svg.php");
        ?>
    </ul>
</div>