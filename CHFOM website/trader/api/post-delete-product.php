<?php
session_start();
if (isset($_POST['product_id'])) {
} else {
    header('location:../login.php');
}


require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$product = $_POST;
$product_id = $product['product_id'];

$sql = "DELETE FROM product WHERE Product_id = $product_id";
$res = $db->execute($sql, "DELETE product");
if ($res['success']) {
    $_SESSION['delete-product-success'] = true;
} else {
    $_SESSION['delete-product-success'] = false;
}
echo ("Ok");
// header("Location:../trader-products.php");
