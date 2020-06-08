<?php
// Transaction is verified and successful...


// $item_id = array();
// $item_quantity = array();
// $item_mc_gross = array();
// // Add all the item numbers, quantities and prices to the above array variables
// for ($i = 1; $i < ($_POST['num_cart_items'] + 1); $i++) {
//     array_push($item_id, $_POST['item_number' . $i]);
//     array_push($item_quantity, $_POST['quantity' . $i]);
//     array_push($item_mc_gross, $_POST['mc_gross_' . $i]);
// }
// Insert the transaction into our transactions table, as the payment status changes the query will execute again and update it, make sure the "txn_id" column is unique
$stmt = $pdo->prepare('INSERT INTO transactions VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE payment_status = VALUES(payment_status)');
$stmt->execute([
    NULL,
    $_POST['txn_id'],
    $_POST['mc_gross'],
    $_POST['payment_status'],
    implode(',', $item_id),
    implode(',', $item_quantity),
    implode(',', $item_mc_gross),
    date('Y-m-d H:i:s'),
    $_POST['payer_email'],
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['address_street'],
    $_POST['address_city'],
    $_POST['address_state'],
    $_POST['address_zip'],
    $_POST['address_country']
]);

exit;
