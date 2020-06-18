<?php
session_start();
require_once("./connection.php");
if (isset($_SESSION['user']['ALTERNATE_ACCESS_ID'])) {
    $admin_id = $_SESSION['user']['ALTERNATE_ACCESS_ID'];
    $sql = "SELECT * FROM admin a, users u WHERE u.User_id = a.User_id and a.Admin_id = $admin_id";
    $res = $db->execFetchAll($sql, "SELECT admin");
    if (count($res) > 0) {
        $_SESSION['user'] = $res[0];
        header("Location:../admin/admin-trader.php");
    } else {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
} else {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
