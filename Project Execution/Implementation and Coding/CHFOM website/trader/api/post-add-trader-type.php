<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
        if (isset($_POST['shop-type'])) {
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

$trader_type = $_POST;
$sql = "INSERT INTO trader_type(Trader_id, Trader_type, Description) VALUES ($trader_type[trader_id],'$trader_type[trader_type]','$trader_type[trader_description]')";
$res = $db->execute($sql, "INSERT trader_type");
if ($res['success']) {
    $_SESSION['add-trader-type-success'] = true;
} else {
    $_SESSION['add-trader-type-success'] = false;
}

header("Location:../trader-add-trader-type.php");
