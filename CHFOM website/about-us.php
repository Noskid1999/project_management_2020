<?php
@include("includes/header.php");
?>

<body>
    <link rel="stylesheet" href="public/css/about-us.css">
    <?php
    @include("includes/navbar.php");
    ?>

    <?php
    @include("includes/search-modal.php");
    ?>
    <section id="about-us-parallex">
        <div class="header-container">
            <div class="overlay"></div>
            <h1 class=" text-center">
                ABOUT US
            </h1>
        </div>
    </section>
    <section id="few-words-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <!-- Quote Classic Big-->
                    <article class="quote-classic-big inset-xl-right-30">
                        <div class="heading-3 quote-classic-big-text">
                            <h1>A FEW WORDS ABOUT OUR STORE</h1>
                        </div>
                    </article>
                    <!-- Bootstrap tabs-->
                    <div class="tabs-custom tabs-horizontal tabs-line" id="tabs-1">
                        <!-- Nav tabs-->
                        <div class="nav-tabs-wrap">
                            <ul class="nav nav-tabs">
                                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tabs-1-1" data-toggle="tab">About</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-2" data-toggle="tab">Our mission</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-3" data-toggle="tab">Our goals</a></li>
                            </ul>
                        </div>
                        <!-- Tab panes-->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tabs-1-1">
                                <p>Cum nomen prarere, omnes peses amor pius, rusticus racanaes. Ubi est mirabilis gemna? Cum gabalium velum, omnes fugaes</p>
                                <p>Ubi est peritus devatio? A falsis, adelphis peritus apolloniates. Est raptus clabulare, cesaris. Cum pulchritudine manducare, omnes genetrixes captis bassus</p>
                            </div>
                            <div class="tab-pane fade" id="tabs-1-2">
                                <p>Vae. Dexter fiscina aliquando vitares animalis est. Nunquam convertam bulla. Cum pars prarere, omnes seculaes</p>
                                <p>Navis dexter historia est. Luba, homo, et indictio. Emeritis eposs ducunt ad animalis. Cum solem assimilant, omnes byssuses vitare clemens, secundus nixuses.</p>
                            </div>
                            <div class="tab-pane fade" id="tabs-1-3">
                                <p>A falsis, historia primus gallus. Est bassus tabes, cesaris. Gallus de mirabilis agripeta, locus mens! Primus ratione</p>
                                <p>Cur eleates accelerare? Heu. Ecce, superbus onus! Demolitione secundus homo est. Cum cacula congregabo, omnes coordinataees acquirere dexter, flavum galataees.</p>
                            </div>
                        </div>
                    </div><a class="btn btn-lg btn-success" href="#">Read more</a>
                </div>
                <div class="col-lg-7 mb-3">
                    <div id="few-words-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#few-words-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#few-words-carousel" data-slide-to="1"></li>
                            <li data-target="#few-words-carousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="public/img/about-us/few-words-carousel-1.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="public/img/about-us/few-words-carousel-2.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="public/img/about-us/few-words-carousel-3.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#few-words-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#few-words-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="stats-parallex">
        <div class="overlay"></div>
        <div class="container" id="stats">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="counter">
                        <div class="row">
                            <div class="col-12 number-container">
                                <h1>2k</h1>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 type-container">
                                <h4>Types of foods
                                    and drinks</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter">
                        <div class="row">
                            <div class="col-12 number-container">
                                <h1>474</h1>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 type-container">
                                <h4>Partners & Traders</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter">
                        <div class="row">
                            <div class="col-12 number-container">
                                <h1>382</h1>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 type-container">
                                <h4>Special
                                    offers</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter">
                        <div class="row">
                            <div class="col-12 number-container">
                                <h1>1267</h1>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 type-container">
                                <h4>Satisfied
                                    clients</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="values-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-3"><img src="public/img/about-us/values-1.png" alt="Value 1"></div>
                <div class="col-md-3 col-6 mb-3"><img src="public/img/about-us/values-2.png" alt="Value 2"></div>
                <div class="col-md-3 col-6 mb-3"><img src="public/img/about-us/values-3.png" alt="Value 3"></div>
                <div class="col-md-3 col-6 mb-3"><img src="public/img/about-us/values-4.png" alt="Value 4"></div>
            </div>
        </div>
    </section>
</body>

<?php
@include("includes/nav-footer.php");
?>

<script src="public/js/others/jquery-ui.js"></script>
<script src="public/js/search.js"></script>

<?php
@include("includes/footer.php");
?>