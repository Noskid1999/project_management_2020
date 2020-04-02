<?php
@include("includes/header.php");
?>
<link rel="stylesheet" href="public/css/login.css">
<?php
@include("includes/navbar.php");
?>

<body>
    <main>
        <div class="dark-overlay"></div>
        <div class="form-container">
            <div class="row">
            </div>
            <form action="#" class="">
                <div class="form-group">
                    <input type="text" placeholder="Enter Your Username" class="form-control" name="username">
                    <?php echo file_get_contents("public/img/svg/person_bg.svg"); ?>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Your Password" class="form-control" name="password">
                    <?php echo file_get_contents("public/img/svg/lock.svg"); ?>
                </div>
                <button type="submit" class="btn btn-primary">SIGN IN</button>

                <div class="form-group forgot-pwd-container">
                    <a href="#">FORGOT PASSWORD?</a>
                </div>
            </form>
        </div>
    </main>
</body>

<?php
@include("includes/nav-footer.php");
?>
<?php
@include("includes/footer.php");
?>