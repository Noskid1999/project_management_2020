<?php
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
                                        <img class="d-block w-100" src="public/img/products/1-1.jpg" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="public/img/products/1-2.jpg" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="public/img/products/1-3.jpg" alt="Third slide">
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
                            <img class="d-block w-100" src="public/img/about-us/few-words-carousel-1.jpg" alt="First slide" data-slide-to="0" data-target="#img-carousel">
                        </div>
                        <div class="col-4 px-1">
                            <img class="d-block w-100" src="public/img/about-us/few-words-carousel-2.jpg" alt="Second slide" data-slide-to="1" data-target="#img-carousel">
                        </div>
                        <div class="col-4 px-0 pl-1">
                            <img class="d-block w-100" src="public/img/about-us/few-words-carousel-3.jpg" alt="Third slide" data-slide-to="2" data-target="#img-carousel">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="">
                        Lorem ipsum
                    </h2>
                    <div class="row mb-3">
                        <div class="col-12 px-0 text-warning" style="font-size: 2rem;">
                            ★★★★★
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2 px-0 text-success" style="font-size: 1.5rem">
                            €500
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 px-0">
                            <p class="mb-0">Category: <span class=" text-dark">Lorem</span></p>
                        </div>
                        <div class="col-12 px-0">
                            <p class="mb-0">Category: <span class=" text-dark">Lorem</span></p>
                        </div>
                        <div class="col-12 px-0">
                            <p class="mb-0">Category: <span class=" text-dark">Lorem</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 px-0">
                            <input type="text" class=" form-control" id="product-amount-input" value="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-max="10" data-min="1">
                        </div>
                        <div class="col-auto position-relative">
                            <span id="add-product-amount">+</span>
                            <span id="subtract-product-amount">-</span>
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
                                    <div class="col-md-2 text-left text-warning">★★★★★</div>
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
        $("#add-product-amount").on("click", () => {
            var curr_val = parseInt($("#product-amount-input").val());
            var max_val = $("#product-amount-input").data("max");
            var min_val = $("#product-amount-input").data("min");
            var req_val = curr_val + 1;
            if (req_val > max_val) {
                req_val = max_val;
            }

            $("#product-amount-input").val(req_val);

        });
        $("#subtract-product-amount").on("click", () => {
            var curr_val = parseInt($("#product-amount-input").val());
            var max_val = $("#product-amount-input").data("max");
            var min_val = $("#product-amount-input").data("min");
            var req_val = curr_val - 1;
            if (req_val < min_val) {
                req_val = min_val;
            }

            $("#product-amount-input").val(req_val);

        });
    </script>
</body>

<?php
@include("includes/footer.php");
?>