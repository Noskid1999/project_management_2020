<?php
session_start();

@require_once("../core/connection.php");
$valid = true;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $valid = false;
    }
    if (isset($_GET['verification_token'])) {
        $validation_token = $_GET['verification_token'];
    } else {
        $valid = false;
    }
    if ($valid) {
        // Get the required user
        $sql = "SELECT * FROM users WHERE User_id = $user_id";
        $res = $db->execFetchAll($sql, "Get Required User");
        if (count($res) > 0) {
            $user = $res[0];
            // Check if the user is already verified
            if ($user['IS_VERIFIED'] == 'Y') {
                $success_message = "You are already verified. Please login to continue.";
                $_SESSION['success_message'] = $success_message;
            } else {
                // Check if the validation token matches the latest token sent
                $sql = "SELECT * FROM validation_token WHERE User_id = " . $user['USER_ID'] . " AND ROWNUM = 1  ORDER BY Validation_token_id DESC";
                $res = $db->execFetchAll($sql, "SELECT validation tokens");
                if (count($res) > 0) {
                    $req_validation_token = $res[0]['VALIDATION_TOKEN'];
                    if ($validation_token == $req_validation_token) {
                        $sql = "UPDATE users SET IS_VERIFIED = 'Y' WHERE User_id = " . $user['USER_ID'];
                        $res = $db->execute($sql, "UPDATE validation");
                        // Verify the user
                        if ($res['success']) {
                            $success_message = "You have been verified. Please login to continue.";
                            $_SESSION['success_message'] = $success_message;
                            // Create a basket for the user if the user type is CUSTOMER
                            if ($user['USER_TYPE'] == "CUSTOMER") {
                                $sql = "INSERT INTO BASKET(CUSTOMER_ID) SELECT CUSTOMER_ID FROM CUSTOMER WHERE USER_ID = " . $user['USER_ID'] . " AND ROWNUM = 1 ORDER BY CUSTOMER_ID DESC";
                                $res = $db->execute($sql, "CREATE basket");
                                if (!$res['success']) {
                                    $failure_message = "Something went wrong in basket creationg. Please try again.";
                                    $_SESSION['failure_message'] = $failure_message;
                                }
                            }
                        } else {
                            $failure_message = "Something went wrong in verification. Please try again.";
                            $_SESSION['failure_message'] = $failure_message;
                        }
                    } else {
                        $failure_message = "Invalid validation token.";
                        $_SESSION['failure_message'] = $failure_message;
                    }
                } else {
                    $failure_message = "No validation token exists for the user.";
                    $_SESSION['failure_message'] = $failure_message;
                }
            }
        }
    }
    // Redirect the user to the login page
    header('Location: http://localhost/login.php');
}
