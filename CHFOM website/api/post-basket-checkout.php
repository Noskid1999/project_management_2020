<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
}

require_once("../core/connection.php");
require_once("../core/validation_functions.php");

$collection_slot_id = $_POST['collection-time'];
$customer_id = $_SESSION['user']['USER_ID'];
$sql = "SELECT * 
                                    FROM product p, basket_product bp
                                    WHERE bp.Basket_id in (
                                        SELECT Basket_id FROM basket WHERE Customer_id = $customer_id
                                    ) AND
                                    bp.Trx_completed = 'N' AND
                                    bp.Product_id = p.Product_id";
$res = $db->execFetchAll($sql, "SELECT basket products");
$products = array();
$basket_product_ids = array();
foreach ($res as $item) {
    array_push($products, array(
        'id' => $item['BASKET_PRODUCT_ID'],
        'name' => $item['PRODUCT_NAME'],
        'quantity' => $item['PRODUCT_QUANTITY'],
        'price' => $item['PRODUCT_PRICE']
    ));
}
require_once("./post-paypal-checkout.php");