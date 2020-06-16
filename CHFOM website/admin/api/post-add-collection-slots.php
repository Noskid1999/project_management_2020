<?php
session_start();
// Chck POST vars
if (!empty($_POST)) {
    if (isset($_POST['admin_id'])) {
    } else {
        header('location:../../login.php');
    }
} else {
    header('location:../../login.php');
}
// Import required DB controller and validations functions
require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$collection_slot = $_POST;
$admin_id = $collection_slot['admin_id'];

$num_days = $collection_slot['num-days'];
$max_orders = $collection_slot['max-orders'];
$sql = "INSERT ALL ";
for ($i = 0; $i < $num_days; $i++) {
    // Get the required dates of the day in the loop
    $req_date = date("Y-m-d", strtotime("+$i day"));
    $req_timestamp = "";
    // Get the date num of the req date
    $day =  date("N", strtotime("+$i day"));
    // if the day of the date matches the days sellected by the admin
    if (in_array($day, $collection_slot['days'])) {
        for ($j = 0; $j < count($collection_slot['start_time']); $j++) {
            // Format the timestamp for insertion
            $req_timestamp_start = $req_date . " " . $collection_slot['start_time'][$j];
            $req_timestamp_end = $req_date . " " . $collection_slot['end_time'][$j];
            $sql .= " INTO collection_slot(added_by, start_time, end_time,maximum_orders) VALUES ($admin_id, TO_TIMESTAMP('$req_timestamp_start','YYYY-MM-DD HH24:MI'),TO_TIMESTAMP('$req_timestamp_end','YYYY-MM-DD HH24:MI'),$max_orders) ";
        }
    }
}

$sql .=" SELECT * FROM DUAL";
echo $sql;
$res = $db->execute($sql, "INSERT collection_slot");
if ($res['success']) {
    $_SESSION['add-collection-slots'] = true;
} else {
    $_SESSION['add-collection-slots'] = false;
}
header("Location:../admin-add-collection-slot.php");
