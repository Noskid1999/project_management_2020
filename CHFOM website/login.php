<?php
session_start();

require_once('core/validation_functions.php');
require_once('core/connection.php');
$email = $password = '';
$error = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        $email = clean_input($_POST['email']);
        $password = clean_input($_POST['password']);
        $valid = true;
        if (empty($email)) {
            $error["email"] = "Empty Email";
            $valid = false;
        }
        if (empty($password)) {
            $error["password"] = "Empty Password";
            $valid = false;
        }
        if ($valid) {
            $sql = "SELECT * FROM users WHERE Email = '$email'";
            $res = $db->execFetchAll($sql, "SELECT email");
            if (count($res) > 0) {
                $user = $res[0];
                if (md5($password) == $user['PASSWORD']) {
                    $_SESSION["user"] = $user;
                    $_SESSION['success_message'] = "Successfully logged in";
                } else {
                    $_SESSION['failure_message'] = "Password Incorrect.";
                    $valid = false;
                }
            } else {
                $_SESSION['failure_message'] = "No user with given email exists.";
                $valid = false;
            }
        }
    }
}

include_once("includes/header.php");
?>
<link rel="stylesheet" href="public/css/login.css">

<body>
    <?php
    include("includes/navbar.php");
    ?>

    <main>
        <div class="dark-overlay"></div>
        <div class="container form-container">
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
            <?php
            if (isset($_SESSION['success_message'])) {
                echo ("<div class='row mb-2'>
                        <div class='col-12 text-center'>
                            <span class='text-success text-large'>
                                " . $_SESSION['success_message'] . "
                            </span>
                        </div>
                    </div>");
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['failure_message'])) {
                echo ("<div class='row mb-2'>
                        <div class='col-12 text-center'>
                            <span class=' text-danger text-large'>
                                " . $_SESSION['failure_message'] . "
                            </span>
                        </div>
                    </div>");
                unset($_SESSION['failure_message']);
            }
            ?>

            <div class="row">
                <div class=" col-lg-5 mx-auto">
                    <div class=" container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Email" class="form-control" name="email">
                                <?php echo file_get_contents("public/img/svg/person_bg.svg"); ?>
                                <?php
                                if (array_key_exists("email", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger text-center">' . $error["email"] . '</div>');
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Enter Your Password" class="form-control" name="password">
                                <?php echo file_get_contents("public/img/svg/lock.svg"); ?>
                                <?php
                                if (array_key_exists("password", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger text-center">' . $error["password"] . '</div>');
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">SIGN IN</button>
                            </div>
                            <form-group>
                                <p class=" text-white text-center">Don't have a account? <a class=" text-info" href="/signup-form.php"> Register</a></p>
                            </form-group>
                            <div class="form-group forgot-pwd-container">
                                <a href="/reset-password.php">FORGOT PASSWORD?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    @include("includes/nav-footer.php");
    ?>
</body>

<?php
@include("includes/footer.php");
?>