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
        <div class="container">
            <div class="row mb-2">
                <div class="sign-in-header container">
                    <div class="col-sm-3 col-5 mx-auto">
                        <img src="public/img/login_key.svg" alt="" class="mx-auto w-100">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <h2 class=" mx-auto" style="color: #FFFFFF;z-index: 999;">
                    Log In
                </h2>
            </div>
            <div class="row">
                <div class="form-container col-lg-5 mx-auto">
                    <div class=" container">
                        <form action="#" class="">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Username" class="form-control" name="username">
                                <?php echo file_get_contents("public/img/svg/person_bg.svg"); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Enter Your Password" class="form-control" name="password">
                                <?php echo file_get_contents("public/img/svg/lock.svg"); ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">SIGN IN</button>
                            </div>
                            <div class="form-group forgot-pwd-container">
                                <a href="#">FORGOT PASSWORD?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<?php
@include("includes/nav-footer.php");
?>
<?php
@include("includes/footer.php");
?>