<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
        if (isset($_POST['product_id'])) {

            require_once("../core/connection.php");
            require_once("../core/validation_functions.php");

            $product_id = $_POST['product_id'];
            $customer_id = $_SESSION['user']['CUSTOMER_ID'];
            $sql = "SELECT * FROM basket_product 
                    WHERE Product_id = $product_id AND 
                    Basket_id in (
                        SELECT Basket_id
                        FROM basket
                        WHERE Customer_id = $customer_id AND ROWNUM=1
                        AND Trx_completed = 'N'
                    )";
            $res = $db->execFetchAll($sql, "Get Product from basket");
            print_r(json_encode($res));
        } else {
            print_r(json_encode(array()));
        }
    } else {
        print_r(json_encode(array()));
    }
} else {
    print_r(json_encode(array()));
}
