<?php
echo $_SERVER["HTTP_HOST"];
require_once(  __DIR__ . '/../../core/send-mail.php');
$data = array(
    'email_address' => 'diksonrajbanshi15@gmail.com',
    'mail_type' => 'INVOICE_CUSTOMER',
    'invoice_id' => '8'
);
send_mail($data);
