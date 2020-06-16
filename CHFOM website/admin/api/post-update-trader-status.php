<?php
session_start();
// Chck POST vars
if (!empty($_POST)) {
    if (isset($_POST['trader_id'])) {
    } else {
        header('location:../../login.php');
    }
} else {
    header('location:../../login.php');
}

// Import required DB controller and validations functions
require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$trader_id = $_POST['trader_id'];
$admin_id = $_POST['admin_id'];
$status = $_POST['status'];

// Update query
$sql = "UPDATE trader SET PROPOSAL_ACCEPTED = '$status', PROPOSAL_ACCEPTED_BY ='$admin_id' WHERE Trader_id = $trader_id";
$res = $db->execute($sql, "UPDATE trader");
if ($res['success']) {
    $_SESSION['update-trader'] = true;
} else {
    $_SESSION['update-trader'] = false;
}
echo (json_encode($res));
