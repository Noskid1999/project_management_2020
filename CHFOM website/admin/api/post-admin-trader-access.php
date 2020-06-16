<?php
session_start();
// Chck POST vars
if (!empty($_POST)) {
    if (isset($_POST['admin_id']) && isset($_POST['trader_id'])) {
    } else {
        header('location:../../login.php');
    }
} else {
    header('location:../../login.php');
}

// Import required DB controller and validations functions
require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$data = $_POST;
// Required insert query
$sql = "INSERT INTO ACCESS_LOG(Trader_id, Admin_id, Activity) VALUES ($data[trader_id],$data[admin_id],'ACCESS')";
$res = $db->execute($sql, "INSERT access_log");
if ($res['success']) {
    $sql = "SELECT * FROM users u, trader t WHERE u.User_id = t.User_id AND t.Trader_id = $data[trader_id]";
    $res = $db->execFetchAll($sql, "SELECT trader");
    if (count($res) > 0) {
        $trader = $res[0];
        $trader['ALTERNATE_ACCESS_ID'] = $data['admin_id'];
        $_SESSION['user'] = $trader;
        header("Location:../../../trader/trader-products.php");
    } else {
        header("Location:../admin-trader.php");
    }
} else {
    header("Location:../admin-trader.php");
}
