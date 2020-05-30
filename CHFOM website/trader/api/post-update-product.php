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
$product_description = oracle_escape_string($product["product_description"]);
$allergy_information = oracle_escape_string($product["allergy_information"]);
$product_price = filter_var($product['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

$sql = "UPDATE product SET PRODUCT_NAME = '$product[product_name]', PRODUCT_DESCRIPTION = '$product_description',PRODUCT_PRICE='$product_price',QUANTITY_PER_ITEM = '$product[quantity_per_item]',STOCK_AVAILABLE=$product[stock_available],MIN_ORDER=$product[min_order], MAX_ORDER=$product[max_order],ALLERGY_INFORMATION='$allergy_information'
WHERE PRODUCT_ID = $product[product_id]";

$res = $db->execute($sql, "UPDATE product");
if ($res['success']) {
    $_SESSION['update-product-success'] = true;
} else {
    print_r($res);
    $_SESSION['update-product-success'] = false;
}
header("Location:../trader-products.php");
