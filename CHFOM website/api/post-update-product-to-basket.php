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
$sql = "
            SELECT Basket_product_id
            FROM basket_product
            WHERE Product_id = $product[product_id] AND
            Basket_id in (
                SELECT Basket_id FROM basket WHERE Customer_id = $customer_id
            ) AND
            Trx_completed ='N' AND
            ROWNUM = 1
            ORDER BY Basket_product_id DESC";
$res = $db->execFetchAll($sql, "GET req basket_product_id");
if (count($res) > 0) {
    $req_basket_product_id = $res[0]["BASKET_PRODUCT_ID"];
    $sql = "UPDATE basket_product
            SET Product_price = $product[product_price],
            Product_quantity = $product[product_quantity],
            Added_to_basket_time = CURRENT_TIMESTAMP
            WHERE Basket_product_id in (
            $req_basket_product_id
            )";
    $res = $db->execute($sql, "DELETE from basket");
} else {
    $res['success'] = false;
}
echo (json_encode($res));
