<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
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

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$user = $_POST;
$user_id = clean_input($user["user_id"]);
$fname = clean_input($user["f_name"]);
$lname = clean_input($user["l_name"]);
$address = clean_input($user['address']);

$sql = "UPDATE users SET First_name = '$fname', Last_name = '$lname', Address = '$address'
        WHERE User_id = $user_id";
$res = $db->execute($sql, "UPDATE user");
echo (json_encode($res));
