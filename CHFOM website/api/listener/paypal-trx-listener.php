<?php

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");
require_once(__DIR__ . '/../../core/send-mail.php');

//look if the parameter 'tx' is set in the GET request and that it does not have a null or empty value
if (isset($_GET['tx']) && ($_GET['tx']) != null && ($_GET['tx']) != "") {
    $tx = $_GET['tx'];

    $pp_hostname = "www.sandbox.paypal.com"; // Change to www.sandbox.paypal.com to test against sandbox


    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-synch';

    $tx_token = $_GET['tx'];
    // Auth token for the PDT
    $auth_token = "pFgztjlwoshJ-SWKu8tMsxMwwHutoqmH7l_4C-3R83snPJUtx52Zomg1UI8";
    $req .= "&tx=$tx_token&at=$auth_token";

    // make a POST request to the Paypal server by the TX get query to get the full transaction details
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    //set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
    //if your server does not bundled with default verisign certificates.
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
    $res = curl_exec($ch);
    curl_close($ch);
    if (!$res) {
        //HTTP ERROR
    } else {
        // parse the data
        $lines = explode("\n", trim($res));
        $keyarray = array();
        if (strcmp($lines[0], "SUCCESS") == 0) {
            for ($i = 1; $i < count($lines); $i++) {
                $temp = explode("=", $lines[$i], 2);
                $keyarray[urldecode($temp[0])] = urldecode($temp[1]);
            }
            // process the order
            // Create a new invoice and insert all the individual products in the payment_detail table 
            $custom_data = json_decode($keyarray['custom'], true);
            $sql = "INSERT INTO INVOICE(Discount_id,INVOICE_TIME,TOTAL_AMOUNT,COLLECTION_SLOT_ID) 
                    VALUES (NULL,CURRENT_TIMESTAMP,$keyarray[mc_gross],$custom_data[collection_slot]) 
                    RETURNING INVOICE_ID INTO :invoice_id";
            $res = $db->execute($sql, "INSERT into invoice", array(
                array(":invoice_id", NULL, 50)
            ));
            file_put_contents('log2.txt', $keyarray['custom']);
            if ($res['success']) {
                $update_sql = "UPDATE basket_product SET TRX_COMPLETED = 'Y' WHERE Basket_product_id in (";
                $invoice_id = $res['data']['invoice_id'];
                $sql = "INSERT ALL ";
                for ($i = 1; $i < ($keyarray['num_cart_items'] + 1); $i++) {
                    // Get indv basket product id
                    $basket_product_id = $keyarray['item_number' . $i];
                    // Add to update sql
                    $update_sql .= "$basket_product_id,";
                    $payment_amount = $keyarray['mc_gross_' . $i];
                    // Getting ready for sql
                    $basket_product = "INTO PAYMENT_DETAIL (BASKET_PRODUCT_ID,PAYMENT_IDENTIFICATION,INVOICE_ID,PAYMENT_TYPE,PAYMENT_EMAIL,TRANSACTION_TIME, FIRST_NAME,LAST_NAME, PAYMENT_AMOUNT,address_street,address_city,address_state,address_zip,address_country) 
                            VALUES ($basket_product_id,'$keyarray[txn_id]',$invoice_id,'PAYPAL','$keyarray[payer_email]',CURRENT_TIMESTAMP,'$keyarray[first_name]','$keyarray[last_name]',$payment_amount,'$keyarray[address_street]','$keyarray[address_city]','$keyarray[address_state]','$keyarray[address_zip]','$keyarray[address_country]') ";
                    // Concat to the sql query
                    $sql .= $basket_product;
                }
                $sql .= "SELECT * FROM DUAL";
                // Removing the last ','
                $update_sql = rtrim($update_sql, ",") . ")";
                file_put_contents('log.txt', $sql);
                file_put_contents('log2.txt', $update_sql);

                $res = $db->execute($sql, "INSERT INTO payment_detail");
                // echo $update_sql;
                // echo $sql;
                if ($res['success']) {
                    $res = $db->execute($update_sql, "UPDATE basket_product");
                }

                // Get Trader list
                $sql = "SELECT DISTINCT t.Trader_id, u.Email
                FROM invoice i,payment_detail pd, basket_product bp, product p,product_type pt, shop s,trader_type tt, trader t,users u
                WHERE i.Invoice_id = $invoice_id
                AND pd.Invoice_id = i.Invoice_id
                AND bp.Basket_product_id = pd.Basket_product_id
                AND bp.Product_id = p.Product_id
                AND p.Product_type_id = pt.Product_type_id
                AND pt.Shop_id = s.Shop_id
                AND s.Trader_type_id = tt.Trader_type_id
                AND tt.Trader_id = t.Trader_id
                AND t.User_id = u.User_id";
                $trader_list = $db->execFetchAll($sql, "GET trader list");

                // Get customer details
                $sql = "SELECT DISTINCT u.Email
                FROM invoice i,payment_detail pd, basket_product bp, basket b,customer c, users u
                WHERE i.Invoice_id =  $invoice_id
                AND pd.Invoice_id = i.Invoice_id
                AND bp.Basket_product_id = pd.Basket_product_id
                AND bp.Basket_id = b.Basket_id
                AND b.Customer_id = c.Customer_id
                AND c.User_id = u.User_id";
                $customer_email_list = $db->execFetchAll($sql, "GET customer email list");

                // Send receipt to customer
                foreach ($customer_email_list as $email) {
                    $data = array(
                        'email_address' => $email['EMAIL'],
                        'mail_type' => 'INVOICE_CUSTOMER',
                        'invoice_id' =>  $invoice_id
                    );
                    send_mail($data);
                }
                // Send receipt to trader
                foreach ($trader_list as $email) {
                    $data = array(
                        'email_address' => $email['EMAIL'],
                        'mail_type' => 'INVOICE_CUSTOMER',
                        'invoice_id' =>  $invoice_id,
                        'trader_id' => $email['TRADER_ID']
                    );
                    send_mail($data);
                }
                $sql = "SELECT Email FROM users WHERE User_type = 'ADMIN' ";
                $admin_list = $db->execFetchAll($sql, "GET admin list");
                // Send the receipt to the admin as received by the customer
                foreach ($admin_list as $email) {
                    $data = array(
                        'email_address' => $email['EMAIL'],
                        'mail_type' => 'INVOICE_CUSTOMER',
                        'invoice_id' =>  $invoice_id
                    );
                    send_mail($data);
                }

                header("location:http://localhost:80");
            } else if (strcmp($lines[0], "FAIL") == 0) {
                // log for manual investigation
            }
        }
    }
} else {
    exitCode();
}


function exitCode()
{
    die("Error");
    //exit with error message
}
