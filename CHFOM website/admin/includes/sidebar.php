<?php
if (!isset($show)) {
  $show = "";
}
if (!isset($sub_show)) {
  $sub_show = "";
}
?>
<div class="close d-block d-md-none position-absolute left-100" onclick="hideSideBar();">
  <i class="fas fa-times d-none"></i>
</div>
<nav class="col-md-2 d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <div id="accordion">
      <!-- <div class="card">
        <div class="card-header" id="prodcutsHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#products" aria-expanded="<?php if ($show == 'products') {
                                                                                                          echo "true";
                                                                                                        } else {
                                                                                                          echo "false";
                                                                                                        } ?>" aria-controls="products">
              <a class="nav-link <?php if ($show == 'products') {
                                    echo "active";
                                  } ?>" href="./trader-products.php">
                <span data-feather="shopping-cart"></span>
                Products
              </a>
            </button>
          </h5>
        </div>
        <div id="products" class="collapse <?php if ($show == 'products') {
                                              echo "show";
                                            } ?>" aria-labelledby="productsHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./trader-products.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'products-details') {
                                                                                                echo "active";
                                                                                              } ?>">
                Products Details
              </a>
              <a href="./trader-add-products.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'add-product') {
                                                                                                    echo "active";
                                                                                                  } ?>">
                Add Product
              </a>
            </div>
          </div>
        </div>
      </div> -->
      
      <div class="card">
        <div class="card-header" id="traderTypeHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#traderType" aria-expanded="<?php if ($show == 'trader-type') {
                                                                                                            echo "true";
                                                                                                          } else {
                                                                                                            echo "false";
                                                                                                          } ?>" aria-controls="trader-type">
              <a class="nav-link <?php if ($show == 'trader-type') {
                                    echo "active";
                                  } ?>" href="./trader-type.php">
                <span data-feather="shopping-cart"></span>
                Trader Type
              </a>
            </button>
          </h5>
        </div>
        <div id="trader-type" class="collapse <?php if ($show == 'trader-type') {
                                                echo "show";
                                              } ?>" aria-labelledby="traderTypeHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./trader-type.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'trader-type-details') {
                                                                                            echo "active";
                                                                                          } ?>">
                Trader Type Details
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="shopsHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#shops" aria-expanded="<?php if ($show == 'shops') {
                                                                                                      echo "true";
                                                                                                    } else {
                                                                                                      echo "false";
                                                                                                    } ?>" aria-controls="shops">
              <a class="nav-link <?php if ($show == 'shops') {
                                    echo "active";
                                  } ?>" href="./trader-shops.php">
                <span data-feather="layers"></span>
                Shops
              </a>
            </button>
          </h5>
        </div>
        <div id="shops" class="collapse <?php if ($show == 'shops') {
                                          echo "show";
                                        } ?>" aria-labelledby="shopsHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./trader-shops.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'shop-details') {
                                                                                            echo "active";
                                                                                          } ?>">
                Shops Details
              </a>
              <a href="./trader-add-shop.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'add-shop') {
                                                                                                echo "active";
                                                                                              } ?>">
                Add Shops
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="profileHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#profile" aria-expanded="<?php if ($show == 'profile') {
                                                                                                        echo "true";
                                                                                                      } else {
                                                                                                        echo "false";
                                                                                                      } ?>" aria-controls="profile">
              <a class="nav-link <?php if ($show == 'profile') {
                                    echo "active";
                                  } ?>" href="./trader-profile.php">
                <span data-feather="user"></span>
                Profile
              </a>
            </button>
          </h5>
        </div>
        <div id="profile" class="collapse <?php if ($show == 'profile') {
                                            echo "show";
                                          } ?>" aria-labelledby="profileHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./trader-profile.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'profile-details') {
                                                                                              echo "active";
                                                                                            } ?>">
                Profile Information
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Saved reports</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Current month
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Last quarter
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Social engagement
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Year-end sale
        </a>
      </li>
    </ul> -->
  </div>
</nav>