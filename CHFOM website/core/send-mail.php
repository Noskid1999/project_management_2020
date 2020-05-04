<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


@require_once("./vendor/autoload.php");
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
        if ($mail_params['mail_type'] == "VERIFICATION") {
            $mail->Subject = "Verification Mail from Cleckhudderfax Online Megastore";
            if (array_key_exists("user_id", $mail_params)) {
                $verification_token = $mail_params['validation_token'];
                $user_id = $mail_params['user_id'];
                $verification_url = "http://localhost/api/verify.php?user_id=$user_id&verification_token=$verification_token";
                $req_mail_template = file_get_contents("templates/verification-mail.php", true);
                $req_mail_template = str_replace('{{ verification_url }}', $verification_url, $req_mail_template);
                $mail->Body = $req_mail_template;
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
            } else {
                return false;
            }
        }
        $mail->send();
        return true;
    } else {
        return false;
    }
}

// @include("includes/header.php");
// $abv = "hello";
// @include("templates/verification-mail.php");
