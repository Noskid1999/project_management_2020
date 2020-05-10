<?php
require_once("../core/connection.php");
if (isset($_POST['action'])) {
    // Set initial query
    $query = "SELECT * FROM product WHERE 1 ";

    // Filter for search
    if (isset($_POST['search_param'])) {
        $search_param = $_POST['search_param'];
        $query .= " AND (PRODUCT_NAME LIKE '%$search_param%' OR DESCRIPTION LIKE '%search_param%')";
    }
    // Fiter for product type
    if (isset($_POST['product_type'])) {
        $product_types = implode("','", $_POST['product_type']);
        $query .= " AND PRODUCT_TYPE_ID IN ('$product_types')";
    }
    // Filter for Min price
    if (isset($_POST['minimum_price']) && !empty($_POST['minimum_price'])) {
        $min_price = $_POST['minimum_price'];
        $query .= " AND PRODUCT_PRICE >= $min_price";
    }
    // Fiter for Max price
    if (isset($_POST['maximum_price']) && !empty($_POST['maximum_price'])) {
        $max_price = $_POST['maximum_price'];
        $query .= " AND PRODUCT_PRICE <= $max_price";
    }
}
