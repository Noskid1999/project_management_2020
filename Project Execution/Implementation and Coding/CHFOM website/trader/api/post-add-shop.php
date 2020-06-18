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
$shop_description = $shop['shop-description'];
$sql = "INSERT INTO SHOP(TRADER_TYPE_ID, SHOP_NAME, SHOP_DESCRIPTION) VALUES (" . $shop['trader-type-id'] . ", '" . $shop['shop-name'] . "', '" . $shop_description . "')";
$res = $db->execute($sql, "INSERT shop");
if ($res['success']) {
    $_SESSION['add-shop-success'] = true;
} else {
    $_SESSION['add-shop-success'] = false;
}

header("Location:../trader-shops.php");