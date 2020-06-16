<?php
if (!empty($_GET)) {
    if (isset($_GET['invoice_id'])) {
        $invoice_id = $_GET['invoice_id'];

        require_once("../../core/connection.php");
        require_once("../../core/validation_functions.php");
        $sql = "UPDATE invoice SET DELIVERY_STATUS='Y' WHERE Invoice_id = $invoice_id";
        $res = $db->execute($sql, "UPDATE invoice");

        echo "<script>window.close();</script>";
    }
} else {

    echo "<script>window.close();</script>";
}
