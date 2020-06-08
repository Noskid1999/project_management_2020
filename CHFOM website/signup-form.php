<?php
session_start();

require_once('core/validation_functions.php');
require_once('core/connection.php');
require_once('core/send-mail.php');
// $sql = "INSERT INTO DEMO_CUSTOMERS(CUSTOMER_ID,CUST_FIRST_NAME,CUST_LAST_NAME) VALUES(200,'test7','test6')";
// $sql = "SELECT * FROM USERS";
// $res = $db->execFetchAll($sql, "test12313");
// var_dump($res);
$error = array();
$fname = $lname = $email   = $password = $cpassword = $pnumber = $address = $vat_number = $trader_type = $trader_description = "";
$trader_check = "false";
$valid = true;
$user_exists = false;
if (!isset($_SESSION['success_message'])) {
    $success_message = $failure_message = "";
} else {
    $success_message = ($_SESSION['success_message']);
    unset($_SESSION['success_message']);
    $failure_message = "";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        $fname = clean_input($_POST["first_name"]);
        $lname = clean_input($_POST["last_name"]);
        $email = clean_input($_POST["email"]);
        $pnumber = clean_input($_POST["pnumber"]);
        $address = clean_input($_POST["address"]);
        $password = clean_input($_POST["password"]);
        $cpassword = clean_input($_POST["confirmpassword"]);
        if (isset($_POST['trader_check'])) {
            $trader_check = $_POST['trader_check'];
        }
        // Error checking for forms
        if (empty($fname)) {
            $error["first_name"] = "Empty First Name";
            $valid = false;
        } else if (!ctype_alpha($fname)) {
            $error["first_name"] = "First Name should contain only alphabets";
            $valid = false;
        }
        if (empty($lname)) {
            $error["last_name"] = "Empty Last Name";
            $valid = false;
        } else if (!ctype_alpha($fname)) {
            $error["last_name"] = "Last Name should contain only alphabets";
            $valid = false;
        }
        if (empty($email)) {
            $error["email"] = "Empty Email";
            $valid = false;
        } else if (!validEmail($email)) {
            $error["email"] = "Please Enter a Valid Email";
            $valid = false;
        }
        if (empty($pnumber)) {
            $error["pnumber"] = "Empty Phone Number";
            $valid = false;
        } else if (!validPhoneNumber($pnumber)) {
            $error['pnumber'] = "Please enter a valid Phone number";
            $valid = false;
        }
        if (empty($address)) {
            $error['address'] = "Empty Address";
            $valid = false;
        }
        if (empty($password)) {
            $error["password"] = "Empty Password";
            $valid = false;
        } else {
            $pass_error = "Password must contain at least";
            $is_valid = true;
            if (strlen($password) < 8) {
                $pass_error .= ", be of length 8";
                $is_valid = false;
            }
            if (strlen($password) > 50) {
                $pass_error .= " be of length less than 50";
                $is_valid = false;
            }
            if (!containsUppercase($password)) {
                //Password must contain at least one Uppercase";
                $pass_error .= ", one Uppercase";
                $is_valid = false;
            }
            if (!containsNumber($password)) {
                // "Password must contain at least one Number";
                $pass_error .= ", one Number";
                $is_valid = false;
            }
            if (!containsSymbol($password)) {
                //"Password must contain at least one Symbol";
                $pass_error .= ", one Symbol.";
                $is_valid = false;
            }
            if (!$is_valid) {
                $error["password"] = $pass_error;
                $valid = false;
            }
        }

        if (empty($cpassword)) {
            $error["confirmpassword"] = "Empty Confirm Password";
            $valid = false;
        } else {
            if ($password != $cpassword) {
                $error["confirmpassword"] = "Confirm Password must be same as Password";
                $valid = false;
            }
        }
        if ($trader_check == "true") {
            $vat_number = clean_input($_POST['vat_registration_number']);
            $trader_type = clean_input($_POST['trader_type']);
            $trader_description = clean_input($_POST['trader_description']);
            if (empty($vat_number)) {
                $error['vat_registration_number'] = "Empty VAT Registration Number";
                $valid = false;
            }
            if (empty($trader_type)) {
                $error['trader_type'] = "Empty Trader Type";
                $valid = false;
            }
            if (empty($trader_description)) {
                $error['trader_description'] = "Empty Trader Description";
                $valid = false;
            }
        }
        if ($valid) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $res = $db->execFetchAll($sql, "SELECT User");
            if (count($res) > 0) {
                $valid = false;
                $user_exists = true;
                $failure_message = "Email is already used";
            }
        }
        if ($valid && !$user_exists) {
            $password = md5($password);
            if ($trader_check == "false") {
                $sql = "INSERT INTO USERS(FIRST_NAME, LAST_NAME, EMAIL,PASSWORD, PHONE_NUMBER,ADDRESS) 
                        VALUES('$fname','$lname','$email','$password','$pnumber','$address')
                        RETURNING USER_ID,EMAIL INTO :id,:email ";
            } else {
                $sql = "INSERT INTO USERS(FIRST_NAME, LAST_NAME, EMAIL,PASSWORD, PHONE_NUMBER,ADDRESS,USER_TYPE) 
                        VALUES('$fname','$lname','$email','$password','$pnumber','$address','TRADER')
                        RETURNING USER_ID,EMAIL INTO :id,:email ";
            }
            $res = $db->execute($sql, "INSERT user", array(
                array(":id", NULL, 50),
                array(":email", NULL, 250)
            ));
            if ($res['success']) {
                $validation_token = substr(md5(time()), 0, 24);
                $user_id = $res['data']['id'];
                $email = $res['data']['email'];
                if ($trader_check == "false") {
                    $sql = "INSERT INTO CUSTOMER(USER_ID) VALUES ($user_id)";
                    $res = $db->execute($sql, "INSERT INTO user_type");
                } else {
                    $sql = "INSERT INTO TRADER(USER_ID,VAT_REGISTRATION_NUMBER) VALUES ($user_id,'$vat_number')
                            RETURNING TRADER_ID INTO :trader_id";
                    $res = $db->execute($sql, "INSERT INTO user_type", array(
                        array(":trader_id", NULL, 50)
                    ));
                    if ($res['success']) {
                        if ($trader_check == "true") {
                            echo "Hello";
                            $trader_id = $res['data']['trader_id'];
                            $sql = "INSERT INTO trader_type(TRADER_ID, TRADER_TYPE, DESCRIPTION) VALUES ($trader_id,'$trader_type','$trader_description')";
                            $response = $db->execute($sql, "INSERT trader type");
                            $res['success'] = $response['success'];
                        }
                    }else{
                        $failure_message = "Failure to insert trader";
                    }
                }
                if ($res['success']) {
                    $sql = "INSERT INTO validation_token(User_id, Validation_token) VALUES ($user_id, '$validation_token')";
                    $res = $db->execute($sql, "INSERT validation token");
                    if ($res['success']) {
                        $data = array(
                            'email_address' => $email,
                            'mail_type' => 'VERIFICATION',
                            'user_id' => $user_id,
                            'validation_token' => $validation_token
                        );
                        if (send_mail($data)) {;
                            $success_message = "Thank you for registering with us. Please check your mail to validate this account.";
                            $_SESSION['success_message'] = $success_message;
                            header("Location:" . htmlspecialchars($_SERVER["PHP_SELF"]));
                        } else {
                            $failure_message = "Validation email send fail.";
                        }
                    } else {
                        $failure_message = "Validation token insert failed.";
                    }
                } else {
                    $failure_message = "Failure to create user type.";
                }
            } else {
                $failure_message = "Failed to create user. Please try again later.";
            }
        }
    }
}
?>
<?php
@include("includes/header.php");
?>
<link rel="stylesheet" href="public/css/form.css">

<body>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-5">
        <div class="row card card-body shadow m-5 mt-0 bg-white rounded main-card d-flex">
            <div class="vector col-md-6 m-0">
                <div class="row">
                    <img src="public/img/lady-vector.png" alt="" />
                </div>
            </div>
            <div class="col-md-6 m-0">
                <div class="row signup-container d-flex justify-content-center">
                    <form class="sup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <img class="avatar" src="public/img/pp.svg" alt="" />
                        <h2>Create an Account</h2>
                        <?php
                        if ($success_message != "") {
                            echo ("<div class='row'>
                                        <div class='col-12'>
                                            <span class='text-success text-large'>
                                            $success_message
                                            </span>
                                        </div>
                                    </div>");
                        }
                        if ($failure_message != "") {
                            echo ("<div class='row'>
                                        <div class='col-12'>
                                            <span class='text-danger text-large'>
                                            $failure_message
                                            </span>
                                        </div>
                                    </div>");
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-6 input-field">
                                <div class="sinput-div one">
                                    <div class="i">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h5>First Name</h5>
                                        <input type="text" class="sinput" name="first_name" value="<?php echo $fname; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("first_name", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </div><div class="error-text text-danger">' . $error["first_name"] . '</div>');
                                }
                                ?>
                            </div>
                            <div class="col-lg-6 input-field">
                                <div class="sinput-div one">
                                    <div class="i">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h5>Last Name</h5>
                                        <input type="text" class="sinput" name="last_name" value="<?php echo $lname; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("last_name", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["last_name"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 input-field">
                                <div class="sinput-div two">
                                    <div class="i">
                                        <i class="fas fa-at"></i>
                                    </div>
                                    <div>
                                        <h5>Email</h5>
                                        <input type="email" class="sinput" name="email" value="<?php echo $email; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("email", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </div><div class="error-text text-danger">' . $error["email"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 input-field">
                                <div class="sinput-div two">
                                    <div class="i">
                                        <i class="fas fa-at"></i>
                                    </div>
                                    <div>
                                        <h5>Phone Number</h5>
                                        <input type="text" class="sinput" name="pnumber" value="<?php echo $pnumber; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("pnumber", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["pnumber"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 input-field">
                                <div class="sinput-div two">
                                    <div class="i">
                                        <i class="fas fa-at"></i>
                                    </div>
                                    <div>
                                        <h5>Address</h5>
                                        <input type="text" class="sinput" name="address" value="<?php echo $address; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("address", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["address"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 input-field">
                                <div class="sinput-div four">
                                    <div class="i">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div>
                                        <h5>Password</h5>
                                        <input type="password" class="form-control sinput" name="password" value="<?php echo $password; ?>" id="pwd-input" />
                                    </div>

                                </div>
                                <?php
                                if (array_key_exists("password", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </div><div class="error-text text-danger">' . $error["password"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 input-field">
                                <div class="sinput-div five">
                                    <div class="i">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div>
                                        <h5>Confirm Password</h5>
                                        <input type="password" class="sinput form-control" name="confirmpassword" id="pwd2-input" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("confirmpassword", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </div><div class="error-text text-danger">' . $error["confirmpassword"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check text-left" style="font-size: 1.2rem;">
                                    <input type="checkbox" class="form-check-input" id="trader_check" name="trader_check" value="true" <?php if ($trader_check == "true") {
                                                                                                                                            echo ("checked");
                                                                                                                                        } ?>>
                                    <label class="form-check-label" for="trader_check">Work As a Trader</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-12 input-field" id="vat_registration_number">
                                <div class="sinput-div two">
                                    <div class="i">
                                        <i class="far fa-id-badge"></i>
                                    </div>
                                    <div>
                                        <h5>VAT Registration Number</h5>
                                        <input type="text" class="sinput" name="vat_registration_number" value="<?php echo $vat_number; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("vat_registration_number", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["vat_registration_number"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-12 input-field" id="trader_type">
                                <div class="sinput-div two">
                                    <div class="i">
                                        <i class="far fa-id-badge"></i>
                                    </div>
                                    <div>
                                        <h5>Trader Type</h5>
                                        <input type="text" class="sinput" name="trader_type" value="<?php echo $trader_type; ?>" />
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("trader_type", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["trader_type"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-12 input-field" id="trader_description">
                                <div class="sinput-div two">
                                    <div class="i h-100">
                                        <i class="far fa-id-badge"></i>
                                    </div>
                                    <div style="height: 90px;">
                                        <h5>Trader Description</h5>
                                        <textarea name="trader_description" class="sinput" id="" cols="30" rows="3" style="resize: none;" value="<?php echo $trader_description; ?>"></textarea>
                                    </div>
                                </div>
                                <?php
                                if (array_key_exists("trader_description", $error)) {
                                    echo ('<div class="error-mark text-danger">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                </div><div class="error-text text-danger">' . $error["trader_description"] . '</div>');
                                }
                                ?>
                            </div>
                        </div>

                        <input type="submit" class="sbtn" value="Register" id="register-btn" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Please enter the same password" />
                        <div class="or-container">
                            <p class="or">or</p>
                        </div>
                        <p>Already Have an Account? <a href="/login.php"> Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    @include("includes/nav-footer.php");
    ?>
    <script>
        const linputs = document.querySelectorAll(".sinput");

        function focusFunc() {
            let parent = this.parentNode.parentNode;
            parent.classList.add("focus");
        }

        function blurFunc() {
            let parent = this.parentNode.parentNode;
            if (this.value == "") {
                parent.classList.remove("focus");
            }
        }

        linputs.forEach((input) => {
            input.addEventListener("focus", focusFunc);
            input.addEventListener("blur", blurFunc);
            $(input).trigger("focus");
        });
        $(linputs[0]).trigger("focus");
        $("#trader_check").on("change", function() {
            var trader_check = ($("#trader_check").is(":checked"));
            if (trader_check) {
                $("#vat_registration_number").parent().removeClass("d-none");
                $("#trader_type").parent().removeClass("d-none");
                $("#trader_description").parent().removeClass("d-none");
            } else {
                $("#vat_registration_number").parent().addClass("d-none");
                $("#trader_type").parent().addClass("d-none");
                $("#trader_description").parent().addClass("d-none");
            }
        })
        var trader_check = ($("#trader_check").is(":checked"));
        if (trader_check) {
            $("#vat_registration_number").parent().removeClass("d-none");
            $("#trader_type").parent().removeClass("d-none");
            $("#trader_description").parent().removeClass("d-none");
        } else {
            $("#vat_registration_number").parent().addClass("d-none");
            $("#trader_type").parent().addClass("d-none");
            $("#trader_description").parent().addClass("d-none");
        }
    </script>
</body>
<?php
@include("includes/footer.php");
?>