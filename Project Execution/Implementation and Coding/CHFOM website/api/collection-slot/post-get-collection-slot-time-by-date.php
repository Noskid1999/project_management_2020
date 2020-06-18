<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
        if (isset($_POST['date'])) {
        } else {
            // header('location:../login.php');
        }
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
}

// Import required DB controller and validations functions
require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");
// Get collection slots as per the given date
$sql = "SELECT Collection_slot_id,
            TO_CHAR(START_TIME,'HH24:MI:SS') || '-' ||TO_CHAR(END_TIME,'HH24:MI:SS') time,
            MAXIMUM_ORDERS,
            REMAINING_ORDERS
            FROM COLLECTION_SLOT 
            WHERE TO_CHAR(Start_time,'YYYY-MM-DD') = '$_POST[date]'  AND 
            Remaining_orders > 0 and 
            TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') > TO_CHAR(CURRENT_TIMESTAMP+1,'YYYY-MM-DD HH24:MI:SS')
            ORDER BY time";
$res = $db->execFetchAll($sql, "SELECT time");
echo (json_encode($res));
