<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
        if (isset($_POST['shop-type'])) {
        } else {
            // header('location:../login.php');
        }
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
}

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");


// Upload configs.
define('UPLOAD_DIR', '../../public/img/products');
define('UPLOAD_MAX_FILE_SIZE', 10485760); // 10MB.
//@changed_2018-02-17_14.28
define('UPLOAD_ALLOWED_MIME_TYPES', 'image/jpeg');

$product = $_POST;
$product_description = oracle_escape_string($product["product_description"]);
$allergy_information = oracle_escape_string($product["allergy_information"]);
$product_price = filter_var($product['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

$sql = "UPDATE product SET PRODUCT_NAME = '$product[product_name]', PRODUCT_DESCRIPTION = '$product_description',PRODUCT_PRICE='$product_price',QUANTITY_PER_ITEM = '$product[quantity_per_item]',STOCK_AVAILABLE=$product[stock_available],MIN_ORDER=$product[min_order], MAX_ORDER=$product[max_order],ALLERGY_INFORMATION='$allergy_information'
WHERE PRODUCT_ID = $product[product_id]";

$res = $db->execute($sql, "UPDATE product");
if ($res['success']) {
    $_SESSION['update-product-success'] = true;
    $allowedMimeTypes = explode(',', UPLOAD_ALLOWED_MIME_TYPES);
    /*
     * Upload files.
     */
    if (!empty($_FILES)) {
        if (isset($_FILES['images']['error'])) {
            $index = 1;
            foreach ($_FILES['images']['error'] as $uploadedFileKey => $uploadedFileError) {
                if ($uploadedFileError === UPLOAD_ERR_NO_FILE) {
                    $errors[] = 'You did not provide any files.';
                } elseif ($uploadedFileError === UPLOAD_ERR_OK) {
                    $uploadedFileName = basename($_FILES['images']['name'][$uploadedFileKey]);
                    $tmp = (explode(".", $uploadedFileName));
                    $ext = end($tmp);
                    if ($_FILES['images']['size'][$uploadedFileKey] <= UPLOAD_MAX_FILE_SIZE) {
                        $uploadedFileType = $_FILES['images']['type'][$uploadedFileKey];
                        $uploadedFileTempName = $_FILES['images']['tmp_name'][$uploadedFileKey];

                        $uploadedFilePath = rtrim(UPLOAD_DIR, '/') . '/' . $product['product_id'] . "-" . $index . "." . $ext;

                        if (in_array($uploadedFileType, $allowedMimeTypes)) {
                            if (!move_uploaded_file($uploadedFileTempName, $uploadedFilePath)) {
                                $errors[] = 'The file "' . $uploadedFileName . '" could not be uploaded.';
                            } else {
                                $filenamesToSave[] = $uploadedFilePath;
                            }
                        } else {
                            $errors[] = 'The extension of the file "' . $uploadedFileName . '" is not valid. Allowed extensions: JPG, JPEG, PNG, or GIF.';
                        }
                    } else {
                        $errors[] = 'The size of the file "' . $uploadedFileName . '" must be of max. ' . (UPLOAD_MAX_FILE_SIZE / 1024) . ' KB';
                    }
                }
                $index++;
            }
        }
    }
} else {
    print_r($res);
    $_SESSION['update-product-success'] = false;
}
header("Location:../trader-products.php");
