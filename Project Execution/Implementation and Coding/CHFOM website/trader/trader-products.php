<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
        $user = $_SESSION['user'];
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
            $sub_show = "products-details";
            include_once("includes/trader-sidebar.php");
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                include_once("includes/trader-hamburger.php");
                ?>
                <!-- Actual data shown start -->
                <main>
                    <h2>Products Details</h2>
                    <?php
                    if (isset($_SESSION['update-product-success'])) {
                        if ($_SESSION['update-product-success']) {
                            echo ("
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Product Updated Successfully
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                        } else {
                            echo ("
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Product Update Unsuccessful
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>");
                        }

                        unset($_SESSION['update-product-success']);
                    }
                    if (isset($_SESSION['delete-product-success'])) {
                        if ($_SESSION['delete-product-success']) {
                            echo ("
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Product Deleted Successfully
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                        } else {
                            echo ("
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Product Delete Unsuccessful
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>");
                        }

                        unset($_SESSION['delete-product-success']);
                    }
                    ?>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Type</th>
                                <th scope="col">Product Description</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Quantity Per Item</th>
                                <th scope="col">Stock Available</th>
                                <th scope="col">Minimum Order</th>
                                <th scope="col">Maximum Order</th>
                                <th scope="col">Allergy Information</th>
                                <th scope="col">Shop</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                                        * 
                                    FROM 
                                        product p, product_type pt, shop s,trader_type tt
                                    WHERE 
                                        p.Product_type_id = pt.Product_type_id AND 
                                        pt.Shop_id = s.Shop_id AND
                                        s.Trader_type_id = tt.Trader_type_id
                                        AND tt.Trader_id = $user[TRADER_ID]";
                            $res = $db->execFetchAll($sql, "SELECT shops");
                            if (count($res) > 0) {
                                foreach ($res as $shop) {
                                    echo ("<tr data-product-id = '" . $shop["PRODUCT_ID"] . "' data-toggle='modal' data-target='#editProduct'>");

                                    echo ("<td>" . $shop['PRODUCT_NAME'] . "</td>");
                                    echo ("<td>" . $shop['PRODUCT_TYPE'] . "</td>");
                                    echo ("<td>" . $shop['PRODUCT_DESCRIPTION'] . "</td>");
                                    echo ("<td>£" . $shop['PRODUCT_PRICE'] . "</td>");
                                    echo ("<td>" . $shop['QUANTITY_PER_ITEM'] . "</td>");
                                    echo ("<td>" . $shop['STOCK_AVAILABLE'] . "</td>");
                                    echo ("<td>" . $shop['MIN_ORDER'] . "</td>");
                                    echo ("<td>" . $shop['MAX_ORDER'] . "</td>");
                                    echo ("<td>" . $shop['ALLERGY_INFORMATION'] . "</td>");
                                    echo ("<td>" . $shop['SHOP_NAME'] . "</td>");

                                    echo ("</tr>");
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </main>
                <!-- Modal -->
                <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="editProductLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="./api/post-update-product.php" method="post" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductLabel">Edit Shop</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="product_id">Product ID</label>
                                        <input type="text" disabled value="" name="product_id_shown" id="product_id_shown" class="form-control">
                                        <input type="hidden" value="" name="product_id" id="product_id" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" value="" name="product_name" id="product_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_description">Product Description</label>
                                        <textarea name="product_description" id="product_description" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" value="" name="product_price" id="product_price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity_per_item">Quantity Per Item</label>
                                        <input type="text" value="" name="quantity_per_item" id="quantity_per_item" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_available">Stock Available</label>
                                        <input type="text" value="" name="stock_available" id="stock_available" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="min_order">Minimum Order</label>
                                        <input type="text" value="" name="min_order" id="min_order" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="max_order">Maximum Order</label>
                                        <input type="text" value="" name="max_order" id="max_order" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="allergy_information">Allergy Information</label>
                                        <textarea name="allergy_information" id="allergy_information" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <img src="" alt="img1" id="preview-img-1" width="100" height="100">
                                        <img src="" alt="img2" id="preview-img-2" width="100" height="100">
                                        <img src="" alt="img3" id="preview-img-3" width="100" height="100">
                                        <input type="file" name="images[]" id="images" multiple>
                                        <small id="emailHelp" class="form-text text-muted">New Images will replace the current images</small>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal">Delete Product</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Confirm delete product?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger " data-dismiss="modal" id="deleteConfirmYes-btn" data-product_id>Yes</button>
                                <button type="button" class="btn btn-success">No</button>
                            </div>
                        </div>
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
    </script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script>
        $("table.table tr").on("click", function(event) {
            var req_tr = event.currentTarget;
            var product_id = req_tr.dataset.productId;
            var product_name = req_tr.children[0].innerText;
            var product_description = req_tr.children[2].innerText;
            var product_price = req_tr.children[3].innerText;
            var quantity_per_item = req_tr.children[4].innerText;
            var stock_available = req_tr.children[5].innerText;
            var min_order = req_tr.children[6].innerText;
            var max_order = req_tr.children[7].innerText;
            var allergy_information = req_tr.children[8].innerText;

            $("#product_id,#product_id_shown").val(product_id);
            $("#product_name").val(product_name);
            $("#product_description").val(product_description);
            $("#product_price").val(product_price);
            $("#quantity_per_item").val(quantity_per_item);
            $("#stock_available").val(stock_available);
            $("#min_order").val(min_order);
            $("#max_order").val(max_order);
            $("#allergy_information").val(allergy_information);
            $("#preview-img-1").attr("src", `../public/img/products/${product_id}-1.jpg`);
            $("#preview-img-2").attr("src", `../public/img/products/${product_id}-2.jpg`);
            $("#preview-img-3").attr("src", `../public/img/products/${product_id}-3.jpg`);
            $("#deleteConfirmYes-btn").attr("data-product_id", product_id);

        })
        $("#deleteConfirmYes-btn").on("click", function(event) {
            var req_product_id = event.currentTarget.dataset.product_id;
            $.ajax({
                method: "POST",
                url: "./api/post-delete-product.php",
                data: {
                    product_id: req_product_id
                },
                success: function(data) {
                    window.location = window.location;
                    // console.log(data);
                    
                },
                error: function(data) {
                    window.location = window.location;
                    // console.log(data);
                }
            })
        })
    </script>

    <?php
    @include("includes/footer.php");
    ?>