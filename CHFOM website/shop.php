<?php
session_start();
if ($_POST) {
  // Redirect to this page.
  header("Location: " . $_SERVER['REQUEST_URI']);
  exit();
}

require_once("core/connection.php");
include("includes/header.php");
?>
<link rel="stylesheet" href="public/css/shop.css">

<body>

  <?php
  @include("includes/navbar.php");
  ?>

  <section class="shop-carousel">
    <div class="header-container">
      <div class="overlay"></div>
      <h1 class=" text-center">
        SHOP
      </h1>
    </div>
  </section>
  <section class="search-container" id="main">
    <div class="row" id="search-results">
      <div class="col-xl-2 col-sm-6" id="results-filter-toggle">
        <div class="row">
          <div class="col-8">
            <p><i class="fas fa-sliders-h"></i>&nbsp;&nbsp;Filter</p>
          </div>
          <div class="col-4">
            <div class="md-form">
              <div class="material-switch">
                <input id="switch-success" name="switch-success" type="checkbox" />
                <label for="switch-success" class="success-color"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8" id="results-query-data">
        <p id="query-results-count">
        </p>
      </div>
      <div class="col-xl-2 col-sm-6" id="sort-data">
        <div class="form-group">
          <label for="sel1">Sort By</label>
          <select class="form-control" id="sel1">
            <option value="name_asc">Name Ascending</option>
            <option value="name_desc">Name Descending</option>
            <option value="price_asc">Price Low to High</option>
            <option value="price_desc">Price High to Low</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row" id="filter-data">
      <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6" id="prod-filter">
        <div class="content">
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0 mt-1">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span class="filter-text">Product Type</span>
                    <span class="filter-plus">+</span>
                  </button>
                </h5>
              </div>

              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                  <form action="#">
                    <?php
                    $sql_product_types = "SELECT * FROM PRODUCT_TYPE";
                    $res = $db->execFetchAll($sql_product_types, "SELECT product_type");
                    foreach ($res as $product_type) {
                      echo ("
                              <p>
                              <label>
                                <input type='checkbox' class='checkbox_selector product_type' value='$product_type[PRODUCT_TYPE_ID]'/>
                                <span>$product_type[PRODUCT_TYPE]</span>
                              </label>
                            </p>");
                    }
                    ?>
                  </form>
                </div>
              </div>
            </div>
            <!-- <div class="card">
              <div class="card-header" id="headingTwo">
                <h5 class="mb-0 mt-1">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span class="filter-text">Category</span>
                    <span class="filter-plus">+</span>
                  </button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  <form action="#">
                    <?php
                    $category = "Male";
                    echo ("
                    <p>
                    <label>
                      <input type='checkbox' class='checkbox_selector category' value = '$category'/>
                      <span>$category</span>
                    </label>
                  </p>");

                    ?>
                  </form>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingThree">
                <h5 class="mb-0 mt-1">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <span class="filter-text">Price</span>
                    <span class="filter-plus">+</span>
                  </button>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                  <form action="#">
                    <?php
                    $min = 0;
                    $max = 100;
                    echo ("
                    <p class='range-field'>
                    <input type='hidden' id='hidden_minimum_price' value='$min' />
                    <input type='hidden' id='hidden_maximum_price' value='$max' />
                      <div id='price_range'></div>
                      <span id ='price_show'>Price Range ($min - $max)</span>
                    
                  </p>");

                    ?>
                  </form>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="col-10" id="prod-data">
        <div class="loading">
          <img src="public/img/gif/loading.gif" alt="">
        </div>
        <div class="product-card-container" id="prod-data-output">

        </div>
        <div class="row">
          <div class="col-12">
            <ul class="pagination float-right" id="pagination-container">
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  @include("includes/nav-footer.php");
  ?>

  <script src="public/js/others/jquery-ui.js"></script>
  <script src="public/js/shop.js"></script>
  <script src="public/js/search.js"></script>

</body>
<?php
@include("includes/footer.php");
?>