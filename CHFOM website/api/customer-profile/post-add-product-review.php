<?php
session_start();
if (!empty($_POST)) {
    if (isset($_POST['product_id'])) {
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
}

require_once("../../core/connection.php");
require_once("../../core/validation_functions.php");
$review = $_POST;
$review_comment = clean_input($review["review"]);
$review_rating = clean_input($review["rating"]);
$sql = "INSERT INTO product_comment (Product_id, User_id, Product_comment,Rating) VALUES ($review[product_id], $review[user_id],'$review_comment','$review_rating')";
$res = $db->execute($sql, "UPDATE user");

header("Location:../../indv-product.php?product_id=$review[product_id]");
