<?php
@include("includes/header.php");
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
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu tristique elit, et vehicula nulla. Fusce arcu tellus, convallis facilisis sem eu, ultrices faucibus massa. Vivamus sollicitudin lectus consequat, pretium ligula ut, malesuada est. Vestibulum aliquet neque ac ex hendrerit vulputate sollicitudin eu nunc</p>
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
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu tristique elit, et vehicula nulla. Fusce arcu tellus, convallis facilisis sem eu, ultrices faucibus massa.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/money.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">QUALITY PRODUCTS</h4>
                            <p class="feature-card-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu tristique elit, et vehicula nulla. Fusce arcu tellus, convallis facilisis sem eu, ultrices faucibus massa.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/clock.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">QUALITY PRODUCTS</h4>
                            <p class="feature-card-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu tristique elit, et vehicula nulla. Fusce arcu tellus, convallis facilisis sem eu, ultrices faucibus massa.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <div class="feature-card-header">
                                <?php echo file_get_contents("public/img/svg/quality.svg"); ?>
                            </div>
                            <h4 class="feature-card-title">QUALITY PRODUCTS</h4>
                            <p class="feature-card-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eu tristique elit, et vehicula nulla. Fusce arcu tellus, convallis facilisis sem eu, ultrices faucibus massa.
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
                    <div class="card">
                        <img class="card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <img class=" card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <img class="card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="public/img/products/product-1-220x160.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">BANANA</h5>
                            <p class="card-text"><b>€10</b></p>
                        </div>
                        <div class="hidden-card-body-container">
                            <div class="hidden-card-body">
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/search.svg"); ?></a>
                                <a href="#" class="btn btn-primary"><?php echo file_get_contents("public/img/svg/cart.svg"); ?></a>
                            </div>
                        </div>
                    </div>

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