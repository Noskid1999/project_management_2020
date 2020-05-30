<?php
session_start();
if (isset($_GET['product_id'])) {
    require_once("core/connection.php");
    require_once("core/validation_functions.php");
    $product_id = clean_input($_GET['product_id']);
    $sql = "SELECT *  
                FROM PRODUCT P,
                PRODUCT_TYPE PT,
                SHOP S,
                TRADER_TYPE TT,
                (
                    SELECT avg(rating) rating 
                    FROM PRODUCT_COMMENT 
                    WHERE Product_id = $product_id
                ) rating 
                WHERE Product_id = $product_id
                AND P.Product_type_id = PT.Product_type_id
                AND PT.Shop_id = S.Shop_id
                AND S.Trader_type_id = TT.Trader_type_id";
    $res = $db->execFetchAll($sql, "SELECT product by product ID");
    if (count($res) > 0) {
        $product = $res[0];
    } else {
        header("Location: shop.php");
    }
} else {
    header("Location: shop.php");
}
@include("includes/header.php");
?>
<link rel="stylesheet" href="public/css/indv-product.css">

<body>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pl-0">
                    <div class="row">
                        <div class="col-12">
                            <div id="img-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#img-carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#img-carousel" data-slide-to="1"></li>
                                    <li data-target="#img-carousel" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-1.jpg" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-2.jpg" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-3.jpg" alt="Third slide">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#img-carousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#img-carousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 px-3" id="small-img-container">
                        <div class="col-4 px-0 pr-1">
                            <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-1.jpg" alt="First slide" data-slide-to="0" data-target="#img-carousel">
                        </div>
                        <div class="col-4 px-1">
                            <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-2.jpg" alt="Second slide" data-slide-to="1" data-target="#img-carousel">
                        </div>
                        <div class="col-4 px-0 pl-1">
                            <img class="d-block w-100" src="public/img/products/<?php echo ($product_id) ?>-3.jpg" alt="Third slide" data-slide-to="2" data-target="#img-carousel">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="">
                        <?php echo $product["PRODUCT_NAME"]; ?>
                    </h2>
                    <div class="row mb-3">
                        <div class="col-12 px-0 " style="font-size: 2rem;">
                            <?php
                            $rating = $product['RATING'];
                            $abs_rating = floor($rating);
                            $half_star = 0;
                            if (($rating - $abs_rating) > 0 && ($rating - $abs_rating) <= 0.75) {
                                $half_star = 1;
                            } else if (($rating - $abs_rating) > 0.75) {
                                $abs_rating++;
                            }
                            for ($i = 0; $i < $abs_rating; $i++) {
                                echo ('<i class="fas fa-star text-warning"></i>');
                            }
                            if ($half_star == 1) {
                                echo ('<i class="fas fa-star-half text-warning"></i>');
                            }

                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2 px-0 text-success" style="font-size: 1.5rem">
                            €<?php echo $product['PRODUCT_PRICE']; ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 px-0">
                            <div class="row">
                                <div class="col-4">
                                    <p class="mb-0">Trader Type: </p>
                                </div>
                                <div class="col-6"><span class=" text-dark"><?php echo $product['TRADER_TYPE']; ?></span></div>
                            </div>
                        </div>
                        <div class="col-12 px-0">
                            <div class="row">
                                <div class="col-4">
                                    <p class="mb-0">Product Type: </p>
                                </div>
                                <div class="col-6"><span class=" text-dark">Lorem</span></div>
                            </div>
                        </div>
                        <div class="col-12 px-0">
                            <div class="row">
                                <div class="col-4">
                                    <p class="mb-0">Trader Type: </p>
                                </div>
                                <div class="col-6"><span class=" text-dark"><?php echo $product['PRODUCT_TYPE']; ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2 px-0">
                            <input type="text" class=" form-control" id="product-amount-input" value="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-max="10" data-min="1">
                        </div>
                        <div class="col-auto position-relative">
                            <span id="add-product-amount">+</span>
                            <span id="subtract-product-amount">-</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 px-0">
                            <div class="row">
                                <div class="col-12 px-0">
                                    <form action="api/post-add-product-to-basket.php" method="post" id="add-product-to-basket">
                                        <input type="hidden" name="product_id" value="<?php echo $product['PRODUCT_ID']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $product['PRODUCT_PRICE']; ?>">
                                        <input type="hidden" name="product_quantity" value="1">
                                        <button class="btn btn-success" id="add-to-basket-btn">Add to Basket</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-auto px-0">
                                    <form action="api/post-update-product-to-basket.php" method="post" id="update-product-to-basket">
                                        <input type="hidden" name="product_id" value="<?php echo $product['PRODUCT_ID']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $product['PRODUCT_PRICE']; ?>">
                                        <input type="hidden" name="product_quantity" value="1">
                                        <button class="btn btn-info d-none" id="update-basket-btn">Update Basket</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="api/post-remove-product-to-basket.php" method="post" id="remove-product-to-basket">
                                        <input type="hidden" name="product_id" value="<?php echo $product['PRODUCT_ID']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $product['PRODUCT_PRICE']; ?>">
                                        <input type="hidden" name="product_quantity" value="1">
                                        <button class="btn btn-danger d-none" id="remove-from-basket-btn">Remove from Basket</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 px-0" id="alert-div">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row">
                <div class="col-12">
                    <h4 class="h4">Product Details</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam nobis, quibusdam itaque velit vel voluptas officia repellendus! Incidunt repellendus assumenda fugiat ea culpa, doloremque perspiciatis suscipit a exercitationem fuga ut officia consectetur quis odio? Ad unde consequuntur, expedita nesciunt alias rerum, assumenda quis beatae itaque reprehenderit quae fuga corporis cum.</p>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row">
                <div class="col-12 pl-0">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="h4">Reviews</h4>
                        </div>
                    </div>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-2 text-left text-warning"><i class="fas fa-star"></i></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <span style="font-size: .8rem;">
                                            by <span class=" text-black-50">Lorem Ipsum</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, itaque!</div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>

        </div>
    </section>
    <?php
    @include("includes/nav-footer.php");
    ?>
    <script>
        $(document).ready(() => {
            var req_data = $("form#add-product-to-basket");
            $.ajax({
                type: "POST",
                url: "./api/post-check-if-product-in-user-basket.php",
                data: req_data.serialize(), // serializes the form's elements.
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.length > 0) {
                        $("#add-to-basket-btn").addClass("d-none");
                        $("#remove-from-basket-btn").removeClass("d-none");
                        $("#update-basket-btn").removeClass("d-none");
                    }
                }
            });
        })
    </script>
    <script>
        // Increase the product amount
        $("#add-product-amount").on("click", () => {
            var curr_val = parseInt($("#product-amount-input").val());
            var max_val = $("#product-amount-input").data("max");
            var min_val = $("#product-amount-input").data("min");
            var req_val = curr_val + 1;
            if (req_val > max_val) {
                req_val = max_val;
            }
            $("#product-amount-input").val(req_val);
            $("input[name=product_quantity]").val(req_val);
        });
        // Decrease the product amount
        $("#subtract-product-amount").on("click", () => {
            var curr_val = parseInt($("#product-amount-input").val());
            var max_val = $("#product-amount-input").data("max");
            var min_val = $("#product-amount-input").data("min");
            var req_val = curr_val - 1;
            if (req_val < min_val) {
                req_val = min_val;
            }
            $("#product-amount-input").val(req_val);
            $("input[name=product_quantity]").val(req_val);
        });
    </script>
    <script>
        // Hamdling add to basket
        $("#add-product-to-basket").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $("#add-to-basket-btn").addClass("d-none");
                        $("#remove-from-basket-btn").removeClass("d-none");
                        $("#update-basket-btn").removeClass("d-none");
                        $("#alert-div").html(`<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                                    Product Added to Basket
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>`);
                    }

                }
            });
        });
        // Handling remove from basket
        $("#remove-product-to-basket").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $("#add-to-basket-btn").removeClass("d-none");
                        $("#remove-from-basket-btn").addClass("d-none");
                        $("#update-basket-btn").addClass("d-none");
                        $("#alert-div").html(`<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                                    Product Removed from Basket
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>`);
                    }
                }
            });
        });
        // Handling update basket
        $("#update-product-to-basket").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $("#alert-div").html(`<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                                    Product Updated in Basket
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>`);
                    }
                }
            });
        });
    </script>
</body>

<?php
@include("includes/footer.php");
?>