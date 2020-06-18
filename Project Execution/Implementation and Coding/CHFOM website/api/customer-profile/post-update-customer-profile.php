<?php
session_start();
if (isset($_SESSION['user']) && !empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
        if (isset($_POST['product_id'])) {
        } else {
            // header('location:../login.php');
        }
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
}

// Import required DB controller, validations functions and send mail functions
require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");
require_once("../../core/send-mail.php");

$user = $_POST;

$user_id = clean_input($user["user_id"]);
$fname = clean_input($user["f_name"]);
$lname = clean_input($user["l_name"]);
$address = clean_input($user['address']);
$email = clean_input($user['email']);

$sql = "UPDATE users SET First_name = '$fname', Last_name = '$lname', Address = '$address'
        WHERE User_id = $user_id";
$res = $db->execute($sql, "UPDATE user");
$data = array(
    'email_address' => $email,
    'mail_type' => 'PROFILE_UPDATE',
    'user_id' => $user_id,
);
send_mail($data);
echo (json_encode($res));
