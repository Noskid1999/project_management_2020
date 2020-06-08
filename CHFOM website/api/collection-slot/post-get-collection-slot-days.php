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

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");

$sql = "SELECT CAST(TRUNC(START_TIME) AS DATE) start_time
        FROM (
            SELECT *
            FROM collection_slot    
            WHERE Remaining_orders>0 AND
            TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') > TO_CHAR(CURRENT_TIMESTAMP+1,'YYYY-MM-DD HH24:MI:SS')
            )collection_slot 
        GROUP BY TRUNC(START_TIME)";
$res = $db->execFetchAll($sql, "SELECT dates from collection slot");
echo (json_encode($res));
