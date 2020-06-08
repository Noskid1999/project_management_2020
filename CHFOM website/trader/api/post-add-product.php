<?php
session_start();
if (isset($_SESSION['user']) && empty($_POST)) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
        if (isset($_POST['product_type_id'])) {
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
$product_name = oracle_escape_string($product['product_name']);
$product_description = oracle_escape_string($product['product_description']);
$allergy_information = oracle_escape_string($product['allergy_information']);
$sql = "INSERT INTO product(
       PRODUCT_TYPE_ID,
       PRODUCT_NAME,
       PRODUCT_DESCRIPTION,
       PRODUCT_PRICE,
       QUANTITY_PER_ITEM,
       STOCK_AVAILABLE,
       MIN_ORDER,
       MAX_ORDER,
       ALLERGY_INFORMATION) VALUES ($product[product_type_id], '$product_name','$product_description',$product[product_price],'$product[quantity_per_item]',$product[stock_available],$product[min_order],$product[max_order],'$allergy_information'
       ) RETURNING PRODUCT_ID INTO :product_id";
$res = $db->execute($sql, "INSERT product", array(
    array(":product_id", NULL, 50)
));
if ($res['success']) {
    $_SESSION['add-shop-success'] = true;


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

                        $uploadedFilePath = rtrim(UPLOAD_DIR, '/') . '/' . $res['data']['product_id'] . "-" . $index . "." . $ext;

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
    $_SESSION['add-shop-success'] = false;
}

// header("Location:../trader-products.php");
