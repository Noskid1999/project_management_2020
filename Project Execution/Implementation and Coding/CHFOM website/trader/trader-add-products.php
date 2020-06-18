<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
    } else {
        $_SESSION['failure_message'] = "You don't have permissions to view this page.";
        header('location:../../login.php');
    }
} else {
    $_SESSION['failure_message'] = "You don't have permissions to view this page.";
    header('location:../../login.php');
}

require_once("../core/connection.php");
require_once("../core/validation_functions.php");
?>

<body>

    <link href="../public/css/trader-dashboard.css" rel="stylesheet" />
    <link href="./public/css/trader-shop.css" rel="stylesheet" />
    <?php
    include_once("includes/trader-navbar.php");
    ?>

    <div class="container-fluid">
        <div class="row position-relative">
            <?php
            $show = "products";
            $sub_show = "add-product";
            include_once("includes/trader-sidebar.php");
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                include_once("includes/trader-hamburger.php");
                ?>
                <!-- Actual data shown start -->
                <main>
                    <h2>Add Product</h2>
                    <?php
                    if (isset($_SESSION['add-product-success'])) {
                        if ($_SESSION['add-product-success']) {
                            echo ("
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Product Added successfully
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>");
                        } else {
                            echo ("
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Product Added Unsuccessful
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                        }

                        unset($_SESSION['add-product-success']);
                    }
                    ?>
                    <div class="container form-container" id="add-product-form-container">
                        <form action="./api/post-add-product.php" method="POST" id="add-product-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="shop_id">Shop:</label>
                                <select name="shop_id" id="shop_id" class="form-control" required>
                                    <option disabled selected style="color: #80969F;">Select the shop type</option>
                                    <!-- value = Trader_type_id && text = Trader_type -->
                                    <?php
                                    $sql = "SELECT 
                                                * 
                                            FROM 
                                                shop s, trader_type tt, trader t 
                                            WHERE    
                                                s.Trader_type_id = tt.Trader_type_id AND
                                                tt.Trader_id = t.Trader_id AND
                                                tt.Approved = 'Y' AND
                                                t.Trader_id = " . $_SESSION['user']['TRADER_ID'];
                                    $res = $db->execFetchAll($sql, "SELECT trader_type");
                                    if (count($res) > 0) {
                                        foreach ($res as $row) {
                                            echo ("<option value='" . $row['SHOP_ID'] . "'>" . $row['SHOP_NAME'] . " | " . $row['TRADER_TYPE'] .  "</option>");
                                        }
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_type_id">Product Type:</label>
                                <select name="product_type_id" id="product_type_id" class="form-control" required>
                                    <option value="" disabled selected style="color: #80969F;">Select product type</option>
                                </select>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductType" id="add-product-type-btn">Add Product Type</button>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" value="" name="product_name" id="product_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" id="product_description" rows="5" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price</label>
                                <input type="text" value="" name="product_price" id="product_price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity_per_item">Quantity Per Item</label>
                                <input type="text" value="" name="quantity_per_item" id="quantity_per_item" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="stock_available">Stock Available</label>
                                <input type="text" value="" name="stock_available" id="stock_available" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="min_order">Minimum Order</label>
                                <input type="text" value="" name="min_order" id="min_order" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="max_order">Maximum Order</label>
                                <input type="text" value="" name="max_order" id="max_order" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="allergy_information">Allergy Information</label>
                                <textarea name="allergy_information" id="allergy_information" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="images">Images of the product:</label>
                                <input type="file" name="images[]" multiple class="form-control">
                            </div>
                            <button class="btn btn-primary" type="submit">Add Product</button>
                        </form>
                    </div>
                </main>
                <!-- Modal -->
                <div class="modal fade" id="addProductType" tabindex="-1" role="dialog" aria-labelledby="addProductTypeLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="./api/post-add-product-type.php" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductTypeLabel">Add Product Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="shop_id">Shop ID</label>
                                        <input type="text" disabled value="" name="shop_id_shown" id="shop_id_shown" class="form-control">
                                        <input type="hidden" value="" name="shop_id" id="add_shop_id" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="product-type">Product Type</label>
                                        <input type="text" value="" name="product_type" id="product-type" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="product-type-description">Product Type Description</label>
                                        <textarea name="product_type_description" id="product-type-description" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Actual data shown end -->
            </main>
        </div>
    </div>

    <!-- Icons -->
    <script>
        function showSideBar() {
            $(".sidebar").addClass("left-0");
            $(".close i").removeClass("d-none");
            $(".close").removeClass("left-100");
        }

        function hideSideBar() {
            $(".sidebar").removeClass("left-0");
            $(".close i").addClass("d-none");
            $(".close").addClass("left-100");
        }

        $('#addProductType').on('shown.bs.modal', function(e) {
            console.log(1);
        })
    </script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        $("#shop_id").on("change", function() {
            var shop_id = $("#shop_id").val();
            $.ajax({
                url: "./api/post-get-product-types-by-shop-id.php",
                method: "POST",
                data: {
                    shop_id: shop_id
                },
                success: function(data) {

                    data = JSON.parse(data);
                    var req_str = `<option value="" disabled selected style="color: #80969F;">Select product type</option>`;
                    data.forEach(product_type => {
                        req_str += `<option value="${product_type.PRODUCT_TYPE_ID}">${product_type.PRODUCT_TYPE}</option>`;

                    });
                    $("#product_type_id").html(req_str);
                },
            })
        });
        $("#add-product-type-btn").on("click", function() {
            var shop_id = $("#shop_id").val();
            $("#shop_id_shown,#add_shop_id").val(shop_id);
        });
    </script>

    <?php
    @include("includes/footer.php");
    ?>