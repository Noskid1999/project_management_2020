<?php
session_start();
// Import required DB controller and validations functions
require_once('core/validation_functions.php');
require_once('core/connection.php');
$valid = true;
$password = $cpassword = '';
$error = array();
$success_message = $failure_message = "";
// If get requirest is made
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $valid = false;
    }
    if (isset($_GET['verification_token'])) {
        $validation_token = $_GET['verification_token'];
    } else {
        $valid = false;
    }
    if ($valid) {
        $sql = "SELECT * FROM users WHERE User_id = $user_id";
        $res = $db->execFetchAll($sql, "Get Required User");
        if (count($res) > 0) {
            $user = $res[0];
            $sql = "SELECT * FROM validation_token WHERE User_id = " . $user['USER_ID'] . " AND ROWNUM = 1  ORDER BY Validation_token_id DESC";
            $res = $db->execFetchAll($sql, "SELECT validation tokens");
            if (count($res) > 0) {
                $req_validation_token = $res[0]['VALIDATION_TOKEN'];
                if ($validation_token == $req_validation_token) {
                    $_SESSION['User_id'] = $user['USER_ID'];
                    $valid = true;
                } else {
                    $valid = false;
                    $failure_message = "Invalid validation token.";
                    $_SESSION['failure_message'] = $failure_message;
                }
            } else {
                $valid = false;
                $failure_message = "No validation token exists for the user.";
                $_SESSION['failure_message'] = $failure_message;
            }
        } else {
            $valid = false;
            $failure_message = "No such user exists.";
            $_SESSION['failure_message'] = $failure_message;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST)) {
        $password = clean_input($_POST['password']);
        $cpassword = clean_input($_POST['cpassword']);
        $valid = true;
        if (empty($password)) {
            $error["password"] = "Empty Password";
            $valid = false;
        }
        if (empty($cpassword)) {
            $error["cpassword"] = "Empty Confirm Password";
            $valid = false;
        } else {
            if ($password != $cpassword) {
                $error["cpassword"] = "Password and Confirm password are not same";
                $valid = false;
            }
        }
        if ($valid) {
            $user_id = $_SESSION['User_id'];
            $password = md5($password);
            $sql = "UPDATE users SET Password = '$password' WHERE User_id = $user_id";
            $res = $db->execute($sql, "UPDATE password");
            if ($res['success']) {
                $success_message = "Password reset successfully.";
                $_SESSION['success_message'] = $success_message;
                header('Location: http://localhost/login.php');
            } else {
                $failure_message = "Password reset error.";
                $_SESSION['failure_message'] = $failure_message;
            }
        }
    }
    $valid = true;
}
?>
<?php
if ($valid) {
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
                        Reset Password
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
                                    <input type="password" placeholder="Confirm your password" class="form-control" name="cpassword">
                                    <?php echo file_get_contents("public/img/svg/lock.svg"); ?>
                                    <?php
                                    if (array_key_exists("cpassword", $error)) {
                                        echo ('<div class="error-mark text-danger">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                    </div><div class="error-text text-danger text-center">' . $error["cpassword"] . '</div>');
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Reset Password</button>
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
}
?>