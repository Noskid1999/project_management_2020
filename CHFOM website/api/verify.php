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
        $sql = "SELECT * FROM users WHERE User_id = $user_id";
        $res = $db->execFetchAll($sql, "Get Required User");
        if (count($res) > 0) {
            $user = $res[0];
            if ($user['IS_VERIFIED'] == 'Y') {
                $success_message = "You are already verified. Please login to continue.";
                $_SESSION['success_message'] = $success_message;
            } else {
                $sql = "SELECT * FROM validation_token WHERE User_id = " . $user['USER_ID'] . " AND ROWNUM = 1  ORDER BY Validation_token_id DESC";
                $res = $db->execFetchAll($sql, "SELECT validation tokens");
                if (count($res) > 0) {
                    $req_validation_token = $res[0]['VALIDATION_TOKEN'];
                    if ($validation_token == $req_validation_token) {
                        $sql = "UPDATE users SET IS_VERIFIED = 'Y' WHERE User_id = " . $user['USER_ID'];
                        echo ($sql);
                        $res = $db->execute($sql, "UPDATE validation");
                        if ($res['success']) {
                            $success_message = "You have been verified. Please login to continue.";
                            $_SESSION['success_message'] = $success_message;
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
    header('Location: http://localhost/login.php');
}
