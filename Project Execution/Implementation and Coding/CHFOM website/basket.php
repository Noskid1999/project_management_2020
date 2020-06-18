<?php
session_start();
if (isset($_SESSION['user'])) {
    if (!empty($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
        $user = $_SESSION['user'];
    } else {
        $_SESSION['failure_message'] = "You need to login to continue.";
        header('Location: http://localhost/login.php');
    }
} else {
    $_SESSION['failure_message'] = "You need to login to continue.";
    header('Location: http://localhost/login.php');
}
include("includes/header.php");
require_once("./core/connection.php");
?>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            vertical-align: middle;
        }

        .prod-description {
            max-height: 6rem;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        tr.product:hover {
            cursor: pointer;
        }

        .datepicker-modal {
            height: auto;
        }

        @media screen and (max-width: 600px) {
            table#cart tbody td .form-control {
                display: inline !important;
            }

            .actions .btn {
                width: 36%;
                margin: 1.5em 0;
            }

            .actions .btn-info {
                float: left;
            }

            .actions .btn-danger {
                float: right;
            }

            table#cart thead {
                display: none;
            }

            table#cart tbody td {
                display: block;
                padding: .6rem;
                min-width: 320px;
            }

            table#cart tbody tr td:first-child {
                background: #80807E;
                color: #fff;
            }

            table#cart tbody td:before {
                content: attr(data-th);
                font-weight: bold;
                display: inline-block;
                width: 8rem;
            }



            table#cart tfoot td {
                display: block;
            }

            table#cart tfoot td .btn {
                display: block;
            }

        }
    </style>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <h2>
                        Basket
                    </h2>
                </div>
            </div>
            <div class="row mt-5">

                <form action="./api/post-basket-checkout.php" method="POST" style="width:100%;">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:8%">Quantity</th>
                                <th style="width:22%" class="text-center">Subtotal</th>
                                <th style="width:10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $customer_id = $_SESSION['user']['CUSTOMER_ID'];
                            $sql = "SELECT * 
                                    FROM product p, basket_product bp
                                    WHERE bp.Basket_id in (
                                        SELECT Basket_id FROM basket WHERE Customer_id = $customer_id
                                    ) AND
                                    bp.Trx_completed = 'N' AND
                                    bp.Product_id = p.Product_id";
                            $res = $db->execFetchAll($sql, "SELECT basket products");
                            ?>
                            <?php
                            $total = 0;
                            foreach ($res as $product) {
                            ?>
                                <tr data-basket-product-id=<?php echo $product["BASKET_PRODUCT_ID"]; ?> data-product-id=<?php echo $product["PRODUCT_ID"]; ?> class="product">
                                    <td data-th="Product">
                                        <div class="row align-items-center">
                                            <!-- <div class="col-sm-2 d-inline d-sm-none d-md-none d-lg-none d-xl-inline"><img src="http://placehold.it/100x100" alt="..." class=" img-fluid" /></div> -->
                                            <div class="col-sm-10">
                                                <h4 class="nomargin"><?php echo $product["PRODUCT_NAME"]; ?></h4>
                                                <p class="prod-description"><?php echo $product["PRODUCT_DESCRIPTION"]; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price">£<?php echo $product["PRODUCT_PRICE"]; ?></td>
                                    <td data-th="Quantity">
                                        <input type="number" class="form-control text-center" value="<?php echo $product["PRODUCT_QUANTITY"]; ?>" disabled>
                                    </td>
                                    <td data-th="Subtotal" class="text-center">£<?php $total +=  ($product["PRODUCT_QUANTITY"] * $product["PRODUCT_PRICE"]);
                                                                                echo ($product["PRODUCT_QUANTITY"] * $product["PRODUCT_PRICE"]); ?></td>
                                    <td class="actions" data-th="">
                                        <button class="btn btn-danger btn-sm remove-product-from-basket red waves-effect waves-light " data-basket-product-id=<?php echo $product["BASKET_PRODUCT_ID"]; ?>><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                        <tfoot>
                            <tr class="visible-xs">
                                <td class=" text-right"><strong>Total</strong></td>
                                <td class=""><strong> £<?php echo $total; ?></strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="/shop.php" class="btn btn-warning waves-effect waves-light ">
                                        <i class="fa fa-angle-left"></i> Continue Shopping
                                    </a>
                                </td>
                                <td colspan="3" class="visible-xs text-left">
                                    <div class="row mb-0">
                                        <div class="col-12">
                                            <label for="collection-date">Collection Date: </label>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="collection-date" <?php if (count($res) == 0) echo "disabled"; ?> required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <label for=""></label>
                                                <select name="collection-time" id="collection-time" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-block waves-effect waves-light h-100" type="submit">Checkout&nbsp;<i class="fab fa-cc-paypal" style="font-size: 2rem;"></i>&nbsp;&nbsp;<i class="fa fa-angle-right d-inline"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </form>
            </div>
        </div>
    </section>
    <?php
    @include("includes/nav-footer.php");
    ?>
    <script>
        // Handling remove from basket
        $(".remove-product-from-basket").on("click", function(e) {
            var basket_product_id = e.currentTarget.dataset.basketProductId;
            $.ajax({
                type: "POST",
                url: "./api/post-remove-product-to-basket-by-basket-product-id.php",
                data: {
                    basket_product_id: basket_product_id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        window.location = window.location;
                    }
                }
            });
        });

        // Handling tr click
        $("tr.product").on("click", function(e) {
            var product_id = e.currentTarget.dataset.productId;
            window.location = "./indv-product.php?product_id=" + product_id;
        });
        // Initialize the datepicket
        $(document).ready(function() {
            $('.datepicker').datepicker({
                disableDayFn: DisableDates,
            });

            $('select').formSelect();
        });
        var dates = [];
        $.ajax({
            method: "POST",
            url: "./api/collection-slot/post-get-collection-slot-days.php",
            success: function(data) {
                data = JSON.parse(data);
                data.forEach(date => {
                    date = new Date(date.START_TIME);
                    dates.push(date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear());
                });
            }
        })

        function DisableDates(date) {
            var req_date = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            return (dates.indexOf(req_date) == -1);
        }

        $("#collection-date").on("change", (event) => {
            var req_date = $("#collection-date").val();
            req_date = new Date(req_date);
            req_date = req_date.getFullYear() + "-" + ((
                        (req_date.getMonth() + 1) < 10
                    ) ?
                    ("0" + (req_date.getMonth() + 1)) :
                    (req_date.getMonth() + 1)) + "-" +
                (req_date.getDate() < 10 ?
                    "0" + req_date.getDate() :
                    req_date.getDate());
            $.ajax({
                method: "POST",
                url: "./api/collection-slot/post-get-collection-slot-time-by-date.php",
                data: {
                    date: req_date
                },
                success: function(data) {
                    data = JSON.parse(data);
                    var req = "";
                    data.forEach(slot => {
                        req += `<option value='${slot.COLLECTION_SLOT_ID}'>${slot.TIME}</option>`
                    });
                    $("#collection-time").html(req);
                    $('select').formSelect();
                }
            });
        });
        $(document).on("change", "#collection-time", (e) => {
            var value = $("#collection-time").val();
        })
    </script>
</body>

<?php
@include("includes/footer.php");
?>