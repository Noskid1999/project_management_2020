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
$customer_id = $_SESSION['user']['USER_ID'];
$sql = "DELETE FROM basket_product 
        WHERE Basket_product_id = $product[basket_product_id]";
$res = $db->execute($sql, "DELETE from basket");
echo (json_encode($res));
