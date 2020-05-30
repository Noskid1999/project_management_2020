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

$shop = $_POST;
$sql = "UPDATE shop SET SHOP_NAME = '" . $shop['shop_name'] . "', SHOP_DESCRIPTION = '" . $shop['shop_description'] . "' WHERE Shop_id = " . $shop['shop_id'];
$res = $db->execute($sql, "UPDATE shop");
if ($res['success']) {
    $_SESSION['update-shop-success'] = true;
} else {
    $_SESSION['update-shop-success'] = false;
}
header("Location:../trader-shops.php");
