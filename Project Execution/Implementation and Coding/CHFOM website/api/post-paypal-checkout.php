<?php
// For testing purposes set this to true, if set to true it will use paypal sandbox
$testmode = true;
$paypalurl = $testmode ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
// If the user clicks the PayPal checkout button...
if (!empty($products)) {
    // Variables we need to pass to paypal
    // Make sure you have a business account and set the "business" variable to your paypal business account email
    $data = array(
        'cmd'            => '_cart',
        'upload'        => '1',
        'lc'            => 'EN',
        'business'         => 'sb-vvc9o2174671@business.example.com',
        // 'return'        => 'http://localhost/invoice.php?test=true',
        'cancel_return'    => 'http://localhost/basket.php?order_status-cancelled',
        'notify_url'    => 'https://4f5636c5c480.ngrok.io/api/listener/paypal-trx-listener.php',
        'currency_code'    => 'GBP',
        'custom' =>     '{"collection_slot":"' . $collection_slot_id . '"}'
    );
    // Add all the products that are in the shopping cart to the data array variable
    for ($i = 0; $i < count($products); $i++) {
        $data['item_number_' . ($i + 1)] = $products[$i]['id'];
        $data['item_name_' . ($i + 1)] = $products[$i]['name'];
        $data['quantity_' . ($i + 1)] = $products[$i]['quantity'];
        $data['amount_' . ($i + 1)] = $products[$i]['price'];
    }
    $test = '';
    foreach ($data as $key => $value) {
        $test .= "$key=$value\n";
    }
    file_put_contents("log2.txt", $test);
    // Send the user to the paypal checkout screen
    header('location:' . $paypalurl . '?' . http_build_query($data));
    // End the script don't need to execute anything else
    exit;
}
