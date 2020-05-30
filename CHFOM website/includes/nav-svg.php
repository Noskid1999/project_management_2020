<li class="nav-item">
    <a class="nav-link" href="" data-toggle="modal" data-target=".search-modal">
        <?php echo file_get_contents("public/img/svg/search.svg"); ?>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/invoice.php">
        <?php echo file_get_contents("public/img/svg/cart.svg"); ?>
    </a>
</li>
<li class="nav-item dropdown">
    <!-- <a class="nav-link" href="/customer-profile.php">
    </a> -->
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo file_get_contents("public/img/svg/person.svg"); ?>
        <?php
        if (isset($_SESSION['user'])) {
            echo ("<span class='text-small'>" . $_SESSION['user']['FIRST_NAME'] . "</span>");
        }
        ?>
    </a>

    <div class="dropdown-menu" style="right:0;left:auto;" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="/cart.php">Cart</a>
        <a class="dropdown-item" href="/customer-profile.php">Profile</a>
        <div class="dropdown-divider"></div>
        <?php
        if (isset($_SESSION['user'])) {
            if (!empty($_SESSION['user'])) {
                echo ('<a class="dropdown-item" href="core/session_end.php">Logout</a>');
            }
        } else {
            echo ('<a class="dropdown-item" href="/login.php">Login</a>');
        }
        ?>
    </div>
</li>