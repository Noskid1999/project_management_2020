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
$shop_id = $_POST['shop_id'];
$sql = "SELECT * FROM product_type WHERE Shop_id = $shop_id";
$res=$db->execFetchAll($sql,"SELECT product_type");
echo json_encode($res);