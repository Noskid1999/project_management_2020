<?php
require_once("../core/connection.php");
require_once("../core/validation_functions.php");
if (isset($_POST['action'])) {
    // Set initial query
    $query = "SELECT p.*,pt.Product_type,pt.Product_type_description,pt.Shop_id FROM product p, product_type pt WHERE 1=1 AND p.Product_type_id = pt.Product_type_id ";
    // Filter for search
    if (isset($_POST['search_param'])) {
        $search_param = strtoupper(clean_input($_POST['search_param']));
        $query .= " AND (UPPER(p.PRODUCT_NAME) LIKE '%$search_param%' OR UPPER(p.PRODUCT_DESCRIPTION) LIKE '%$search_param%')";
    }
    // Fiter for product type
    if (isset($_POST['product_type'])) {
        $product_types = implode("','", $_POST['product_type']);
        $query .= " AND p.PRODUCT_TYPE_ID IN ('$product_types')";
    }
    // Filter for shop
    if (isset($_POST['shop'])) {
        $shop = implode("','", $_POST['shop']);
        $query .= " AND pt.SHOP_ID IN ('$shop')";
    }
    // Filter for Min price
    if (isset($_POST['minimum_price']) && !empty($_POST['minimum_price'])) {
        $min_price = $_POST['minimum_price'];
        $query .= " AND p.PRODUCT_PRICE >= $min_price";
    }
    // Fiter for Max price
    if (isset($_POST['maximum_price']) && !empty($_POST['maximum_price'])) {
        $max_price = $_POST['maximum_price'];
        $query .= " AND p.PRODUCT_PRICE <= $max_price";
    }
    // Check if offset if present
    if(isset($_POST['offset']) && !empty($_POST['offset'])){
        $offset= $_POST['offset'];
    }else{
        $offset = 0;
    }

    // For total number of results
    $count_query = "SELECT COUNT(*) COUNT FROM ($query)";
    $res = $db->execFetchAll($count_query, "COUNT products");
    if (count($res) > 0) {
        $total_count = (int) $res[0]['COUNT'];
        $script = "<script>";
        $script .= "var total_num_data = $total_count;
                    $('#query-results-count').html('Total Results : $total_count');            
        ";
        $filter_count = 48;
        // For offset / Pagination of the products page
        if (isset($_POST['offset'])) {
            $offset = (int) $_POST['offset'];
        }
        // For filter count of the products page
        if (isset($_POST['filter_count'])) {
            $filter_count = (int) $_POST['filter_count'];
        }
        // For script to generate total results and the pagination in the page
        $script .= "generate_pagination($offset+1,$total_count);";
        $script .= "</script>";
        echo $script;

        $final_query = "SELECT * FROM (" . $query;
        $final_query = "select * 
        from ( select /*+ FIRST_ROWS(n) */ 
        a.*, ROWNUM rnum 
            from ( $query ) a 
            where ROWNUM <= ($offset+1)*$filter_count ) t
      where rnum  >= ($offset*$filter_count)+1";
        // For pagination of the data
        // $final_query .= " AND ROWNUM <= ($offset+1)*$filter_count ";
        // For sorting of the data
        if (isset($_POST['sort_query'])) {
            $sort_query = $_POST['sort_query'];
            $final_query .= " ORDER BY $sort_query";
        }
        // $final_query .= " ) WHERE ROWNUM >= $offset*$filter_count";

        $output = "";   
        $req_data = $db->execFetchAll($final_query, "SELECT req products");
        if (count($req_data) > 0) {
            $product = "test";
            foreach ($req_data as $product) {
                $output .= "<div class='card' data-product-id='$product[PRODUCT_ID]'>
              <img class='card-img-top' src='public/img/products/" . $product['PRODUCT_ID'] . "-1.jpg' alt='Card image cap'>
              <div class='card-body'>
                <h5 class='card-title'>" . $product['PRODUCT_NAME']  ."</h5>
                <p class='card-text'><b>£" . $product['PRODUCT_PRICE'] ."</b></p>
              </div>
              <div class='hidden-card-body-container'>
                <div class='hidden-card-body'>
                  <a href='/indv-product.php?product_id=" . $product['PRODUCT_ID'] . "' class='btn btn-primary'>" . file_get_contents('../public/img/svg/search.svg') . "</a>
                  
                </div>
              </div>
            </div>";
            }
            // <a href='#' class='btn btn-primary'>" . file_get_contents('../public/img/svg/cart.svg') . "</a>
            echo ($output);
        } else {
            echo ("No data found");
        }
        // echo $query;
    }
}
