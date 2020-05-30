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

$product = $_POST;
$product_name = oracle_escape_string($product['product_name']);
$product_description = oracle_escape_string($product['product_description']);
$allergy_information = oracle_escape_string($product['allergy_information']);
$sql = "INSERT INTO product(
       PRODUCT_TYPE_ID,
       PRODUCT_NAME,
       PRODUCT_DESCRIPTION,
       PRODUCT_PRICE,
       QUANTITY_PER_ITEM,
       STOCK_AVAILABLE,
       MIN_ORDER,
       MAX_ORDER,
       ALLERGY_INFORMATION) VALUES ($product[product_type_id], '$product_name','$product_description',$product[product_price],'$product[quantity_per_item]',$product[stock_available],$product[min_order],$product[max_order],'$allergy_information'
       )";
$res = $db->execute($sql, "INSERT product");
if ($res['success']) {
    $_SESSION['add-shop-success'] = true;
} else {
    $_SESSION['add-shop-success'] = false;
}

header("Location:../trader-products.php");