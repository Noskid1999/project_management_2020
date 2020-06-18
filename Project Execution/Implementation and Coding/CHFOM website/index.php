<?php
@include("includes/header.php");
require_once("core/connection.php");
require_once("core/validation_functions.php");
?>

<body>
    <?php
    @include("includes/navbar.php");
    ?>

    <main>
        <!-- Carousel -->
        <div id="home-carousel" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="public/img/homepage/slide-1.jpg" alt="Slide 1" width="1100" height="500">
                    <div class="carousel-caption">
                        <h4>Welcome to our Online Store</h4>
                        <h1>Cleckhudderfax <br />Online <br />Megastore</h1>
                        <h3>Where Needs Are Fulfilled</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/img/homepage/slide-2.jpg" alt="Slide 2" width="1100" height="500">
                    <div class="carousel-caption">
                        <h4>A Wide Selection of Artisan Breads</h4>
                        <h1>Baked Goods</h1>
                        <h3>Available At Our Store</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="public/img/homepage/slide-3.jpg" alt="Slide 3" width="1100" height="500">
                    <div class="carousel-caption">
                        <h4>Fresh And Tasty</h4>
                        <h1>Vegetables</h1>
                        <h3>That You Love</h3>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#home-carousel" data-slide="prev">
                <div class="span-container">
                    <p>Prev</p>
                    <span class="carousel-control-prev-icon"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#home-carousel" data-slide="next">
                <div class="span-container">
                    <p>Next</p>
                    <span class="carousel-control-next-icon"></span>
                </div>
            </a>
        </div>
        <!-- About Us -->
        <section id="about-us">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-6 img-container">
                        <img src="public/img/homepage/shopping_bag.jpg" alt="Shopping Bag with Items" width="100%">
                    </div>
                    <div class="col-lg-6 description-container">
                        <h4>A Few Words About Our Store</h4>
                        <h1>ABOUT US</h1>
                        <p>CHFOM is an online marketplace where we intend to supply quality products from our local traders. We deal with multiple traders and provide our buyers with a variety of fresh produce from the local farm. </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features -->
        <section id="features">
            <div class="dark-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/quality.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">QUALITY PRODUCTS</h4>
                            <p class="feature-card-body">
                                All the products are organic and produced locally, exclusively imported to our online store from the sellers.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/money.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">EASY PAYMENT</h4>
                            <p class="feature-card-body">
                                Easily pay for your products with PayPal and choose the time suited for you from the available options.

                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/clock.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">EASE OF ACCESS</h4>
                            <p class="feature-card-body">
                                Easily accessible, shop efficiently anytime anywhere, saving your valuable time.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/quality.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">VARIETY GOODS</h4>
                            <p class="feature-card-body">
                                Choose products from multiple categories, shop from any place with just few clicks.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- New Arrivals -->
        <section id="new-arrivals">
            <div class="container">
                <div class="header-container">
                    <h2>Latest Arrivals</h2>
                    <h1>NEW PRODUCTS</h1>
                </div>
                <div class="product-card-container">
                    <?php
                    $query = "WITH cte_products AS (
                        SELECT 
                            product.*, ROW_NUMBER() OVER (ORDER BY PRODUCT_ADDED_TIME DESC) row_num
                        FROM 
                            PRODUCT
                    )
                    SELECT * FROM cte_products
                    WHERE row_num <= 6";
                    $output ="";
                    $req_data = $db->execFetchAll($query, "SELECT req products");
                    if (count($req_data) > 0) {
                        foreach ($req_data as $product) {
                            $output .= "<div class='card' data-product-id='$product[PRODUCT_ID]'>
                        <img class='card-img-top' src='public/img/products/" . $product['PRODUCT_ID'] . "-1.jpg' alt='Card image cap'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . $product['PRODUCT_NAME']  . "</h5>
                            <p class='card-text'><b>£" . $product['PRODUCT_PRICE'] . "</b></p>
                        </div>
                        <div class='hidden-card-body-container'>
                            <div class='hidden-card-body'>
                            <a href='/indv-product.php?product_id=" . $product['PRODUCT_ID'] . "' class='btn btn-primary'>" . file_get_contents('public/img/svg/search.svg') . "</a>
                            
                            </div>
                        </div>
                        </div>";
                        }
                    }
                    echo $output;
                    ?>

                </div>

            </div>
        </section>
    </main>
    <?php
    @include("includes/nav-footer.php");
    ?>
</body>
<?php
@include("includes/footer.php");
?>