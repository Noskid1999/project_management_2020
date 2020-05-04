<div class="modal fade search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class=" form-container"></form>
                <div class="form-group">
                    <input type="text" placeholder="Enter a product name to search" class=" form-control">
                </div>
                <div class="product-card-container">
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                    ?>
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
                    <?php

                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>