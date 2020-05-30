<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
    } else {
        // header('location:../login.php');
    }
} else {
    // header('location:../login.php');
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
            $show = "shops";
            $sub_show = "shop-details";
            include_once("includes/trader-sidebar.php");
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                include_once("includes/trader-hamburger.php");
                ?>
                <!-- Actual data shown start -->
                <main>
                    <h2>Shops Dashboard</h2>
                    <?php
                    if (isset($_SESSION['update-shop-success'])) {
                        if ($_SESSION['update-shop-success']) {
                            echo ("
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Shop Updated Successfully
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                        } else {
                            echo ("
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Shop Update Unsuccessful
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>");
                        }

                        unset($_SESSION['update-shop-success']);
                    }
                    ?>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Shop Name</th>
                                <th scope="col">Shop Description</th>
                                <th scope="col">Trader Type</th>
                                <th scope="col">Product Type Count</th>
                                <th scope="col">Product Count</th>
                                <th scope="col">Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                                    s.*,tt.*,
                                (
                                    SELECT count(*) FROM product_type where s.Shop_id = Shop_id
                                ) count_product_type,
                                (
                                    SELECT 
                                        count(*) 
                                    FROM 
                                        product p, product_type pt 
                                    WHERE  
                                        s.Shop_id = pt.Shop_id
                                    AND  p.Product_type_id = pt.Product_type_id
                                ) count_product
                                FROM 
                                    shop s, trader_type tt 
                                WHERE
                                    s.Trader_type_id = tt.Trader_type_id 
                                ORDER BY 
                                    s.Shop_id";
                            $res = $db->execFetchAll($sql, "SELECT shops");
                            if (count($res) > 0) {
                                foreach ($res as $shop) {
                                    echo ("<tr data-shop-id = '" . $shop["SHOP_ID"] . "' data-toggle='modal' data-target='#editShop'>");

                                    echo ("<td>" . $shop['SHOP_NAME'] . "</td>");
                                    echo ("<td>" . $shop['SHOP_DESCRIPTION'] . "</td>");
                                    echo ("<td>" . $shop['TRADER_TYPE'] . "</td>");
                                    echo ("<td>" . $shop['COUNT_PRODUCT_TYPE'] . "</td>");
                                    echo ("<td>" . $shop['COUNT_PRODUCT'] . "</td>");
                                    echo ("<td>" . $shop['APPROVED'] . "</td>");

                                    echo ("</tr>");
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </main>
                <!-- Modal -->
                <div class="modal fade" id="editShop" tabindex="-1" role="dialog" aria-labelledby="editShopLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="./api/post-update-shop.php" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editShopLabel">Edit Shop</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="shop_id">Shop ID</label>
                                        <input type="text" disabled value="" name="shop_id_shown" id="shop_id_shown" class="form-control">
                                        <input type="hidden" value="" name="shop_id" id="shop_id" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_name">Shop Name</label>
                                        <input type="text" value="" name="shop_name" id="shop_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_description">Shop Description</label>
                                        <textarea name="shop_description" id="shop_description" rows="10" class="form-control"></textarea>
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
    </script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script>
        $("table.table tr").on("click", function(event) {
            var req_tr = event.currentTarget;
            var shop_id = req_tr.dataset.shopId;
            var shop_name = req_tr.children[0].innerText;
            var shop_description = req_tr.children[1].innerText;

            $("#shop_id,#shop_id_shown").val(shop_id);
            $("#shop_name").val(shop_name);
            $("#shop_description").val(shop_description);

        })
    </script>

    <?php
    @include("includes/footer.php");
    ?>