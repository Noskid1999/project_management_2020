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

require_once("../core/connection.php");
require_once("../core/validation_functions.php");

$product = $_POST;
$customer_id = $_SESSION['user']['CUSTOMER_ID'];
$sql = "INSERT INTO 
        basket_product(Basket_id, Product_id,  Product_price,Added_to_basket_time,Product_quantity) 
        VALUES (
            (
                SELECT Basket_id FROM basket WHERE Customer_id = $customer_id
            ), 
            $product[product_id],$product[product_price],CURRENT_TIMESTAMP,$product[product_quantity])";
$res = $db->execute($sql, "INSERT into basket");
echo (json_encode($res));
