<?php
session_start();
if (!empty($_POST)) {
    if (isset($_POST['trader_type_id'])) {
    } else {
        header('location:../../login.php');
    }
} else {
    header('location:../../login.php');
}

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$trader_type_id = $_POST['trader_type_id'];
$admin_id = $_POST['admin_id'];
$status = $_POST['status'];

$sql = "UPDATE trader_type SET Approved = '$status', Approved_by ='$admin_id' WHERE Trader_type_id = $trader_type_id";
$res = $db->execute($sql, "UPDATE trader_type");
if ($res['success']) {
    $_SESSION['update-trader-type'] = true;
} else {
    $_SESSION['update-trader-type'] = false;
}
echo (json_encode($res));
