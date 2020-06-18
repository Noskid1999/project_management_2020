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

$product_type_arr = $_POST;
var_dump($product_type_arr);
$product_type = clean_input($product_type_arr["product_type"]);
$product_description = clean_input($product_type_arr["product_type_description"]);
$sql = "INSERT INTO PRODUCT_TYPE(SHOP_ID, PRODUCT_TYPE, PRODUCT_TYPE_DESCRIPTION) VALUES (" . $product_type_arr['shop_id'] . ", '" . $product_type . "', '" . $product_description . "')";
$res = $db->execute($sql, "INSERT product_type");
if ($res['success']) {
    $_SESSION['add-product-type-success'] = true;
} else {
    $_SESSION['add-product-type-success'] = false;
}

header("Location:../trader-add-products.php");
