<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once(__DIR__ . "/../vendor/autoload.php");
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'chfom.pm2020@gmail.com';                     // SMTP username
    $mail->Password   = 'project_management_2020';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('chfom.pm2020@gmail.com', 'CHFOM');    // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
function send_mail($mail_params)
{
    global $mail;
    $required_keys = [
        'email_address',
        'mail_type'
    ];
    $input_keys = array_keys($mail_params);
    // Check if all required keys are there
    $missing_params = array_diff($required_keys, $input_keys);
    if (empty($missing_params)) {
        // Set send to with name if available
        if (array_key_exists("name", $mail_params)) {
            $mail->addAddress($mail_params['email_address'], $mail_params['name']);
        } else {
            $mail->addAddress($mail_params['email_address']);
        }
        $mail_send = false;
        if ($mail_params['mail_type'] == "VERIFICATION") {
            $mail->Subject = "Verification Mail from Cleckhudderfax Online Megastore";
            if (array_key_exists("user_id", $mail_params)) {
                $verification_token = $mail_params['validation_token'];
                $user_id = $mail_params['user_id'];
                $verification_url = "http://localhost/api/verify.php?user_id=$user_id&verification_token=$verification_token";
                $req_mail_template = file_get_contents("templates/verification-mail.php", true);
                $req_mail_template = str_replace('{{ verification_url }}', $verification_url, $req_mail_template);
                $mail->Body = $req_mail_template;
                $mail_send = true;
            } else {
                return false;
            }
        } else if ($mail_params['mail_type'] == "RESETPASSWORD") {
            $mail->Subject = "Reset Password Mail from Cleckhudderfax Online Megastore";
            if (array_key_exists("user_id", $mail_params)) {
                $verification_token = $mail_params['validation_token'];
                $user_id = $mail_params['user_id'];
                $forgot_password_url = "http://localhost/forgot-password.php?user_id=$user_id&verification_token=$verification_token";
                $req_mail_template = file_get_contents("templates/forgot-password.php", true);
                $req_mail_template = str_replace('{{ forgot_password_url }}', $forgot_password_url, $req_mail_template);
                $mail->Body = $req_mail_template;
                $mail_send = true;
            } else {
                return false;
            }
        } else if ($mail_params['mail_type'] == "INVOICE_CUSTOMER") {
            $invoice_id = $mail_params['invoice_id'];

            $sql = "SELECT p.*,i.*,pd.*,bp.*,TO_CHAR(pd.TRANSACTION_TIME, 'YYYY-MM-DD HH24:MI') req_transaction_time
                  FROM invoice i,payment_detail pd, basket_product bp, product p
                  WHERE i.Invoice_id = $invoice_id
                  AND pd.Invoice_id = i.Invoice_id
                  AND bp.Basket_product_id = pd.Basket_product_id
                  AND bp.Product_id = p.Product_id";
            $res = $GLOBALS['db']->execFetchAll($sql, "GET invoice details");
            $total = 0;
            $output = "";
            foreach ($res as $item) {
                $output .= "
                    <tr>
                      <td align='left' width='75%' style='padding: 6px 12px;font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;'>$item[PRODUCT_NAME] (x$item[PRODUCT_QUANTITY])</td>
                      <td align='left' width='25%' style='padding: 6px 12px;font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;'>£$item[PRODUCT_PRICE]</td>
                    </tr>";
                $total += $item['PRODUCT_PRICE'];
            }
            $req_mail_template = file_get_contents("templates/invoice.php", true);

            $req_mail_template = str_replace('{{ invoice_id }}', $invoice_id, $req_mail_template);
            $req_mail_template = str_replace('{{ invoice_table }}', $output, $req_mail_template);
            $req_mail_template = str_replace('{{ invoice_total }}', $total, $req_mail_template);
            $invoice_billing_add = $res[0]['FIRST_NAME'] . " " . $res[0]['LAST_NAME'] . "<br>" . $res[0]["ADDRESS_STREET"] . "<br/>" . $res[0]['ADDRESS_CITY'] . ", " . $res[0]["ADDRESS_STATE"] . " " . $res[0]['ADDRESS_ZIP'];
            $req_mail_template = str_replace('{{ invoice_billing_add }}', $invoice_billing_add, $req_mail_template);

            $mail->Subject = "Order Receipt From CHFOM";
            $mail->Body = $req_mail_template;
            $mail_send = true;
        } else if ($mail_params['mail_type'] == "INVOICE_TRADER") {
            $invoice_id = $mail_params['invoice_id'];
            $trader_id = $mail_params['trader_id'];
            $sql = "SELECT p.*,i.*,pd.*,bp.*,tt.Trader_id,TO_CHAR(pd.TRANSACTION_TIME, 'YYYY-MM-DD HH24:MI') req_transaction_time
                        FROM invoice i,payment_detail pd, basket_product bp, product p, product_type pt, shop s, trader_type tt
                        WHERE i.Invoice_id = ${invoice_id}
                        AND pd.Invoice_id = i.Invoice_id
                        AND bp.Basket_product_id = pd.Basket_product_id
                        AND bp.Product_id = p.Product_id
                        AND p.Product_type_id = pt.Product_type_id
                        AND pt.Shop_id = s.Shop_id
                        AND s.Trader_type_id = tt.Trader_type_id
                        AND tt.Trader_id = ${trader_id}";
            $res = $GLOBALS['db']->execFetchAll($sql, "GET invoice details");
            $total = 0;
            $output = "";
            foreach ($res as $item) {
                $output .= "
                    <tr>
                      <td align='left' width='75%' style='padding: 6px 12px;font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;'>$item[PRODUCT_NAME] (x$item[PRODUCT_QUANTITY])</td>
                      <td align='left' width='25%' style='padding: 6px 12px;font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;'>£$item[PRODUCT_PRICE]</td>
                    </tr>";
                $total += $item['PRODUCT_PRICE'];
            }
            $req_mail_template = file_get_contents("templates/invoice.php", true);

            $req_mail_template = str_replace('{{ invoice_id }}', $invoice_id, $req_mail_template);
            $req_mail_template = str_replace('{{ invoice_table }}', $output, $req_mail_template);
            $req_mail_template = str_replace('{{ invoice_total }}', $total, $req_mail_template);
            $invoice_billing_add = $res[0]['FIRST_NAME'] . " " . $res[0]['LAST_NAME'] . "<br>" . $res[0]["ADDRESS_STREET"] . "<br/>" . $res[0]['ADDRESS_CITY'] . ", " . $res[0]["ADDRESS_STATE"] . " " . $res[0]['ADDRESS_ZIP'];
            $req_mail_template = str_replace('{{ invoice_billing_add }}', $invoice_billing_add, $req_mail_template);

            $mail->Subject = "Order Receipt From CHFOM for Customer";
            $mail->Body = $req_mail_template;
            $mail_send = true;
        } else if ($mail_params['mail_type'] == "PROFILE_UPDATE") {
            $mail->Subject = "Profile Update Notification";
            if (array_key_exists("user_id", $mail_params)) {
                $user_id = $mail_params['user_id'];
                $req_mail_template = file_get_contents("templates/profile-update.php", true);
                $mail->Body = $req_mail_template;
                $mail_send = true;
            } else {
                return false;
            }
        }
        if ($mail_send) {
            $mail->send();
        }
        return true;
    } else {
        return false;
    }
}
function getRenderedHTML($path)
{
    ob_start();
    include($path);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}
function getRenderedInvoiceCustomer($path, $invoice_id)
{
    ob_start();
    include($path);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}
function getRenderedInvoiceTrader($path, $invoice_id, $trader_id)
{
    ob_start();
    include($path);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

// @include("includes/header.php");
// $abv = "hello";
// @include("templates/verification-mail.php");
