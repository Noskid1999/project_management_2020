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
      <div class="card">
        <div class="card-header" id="prodcutsHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#trader" aria-expanded="<?php if ($show == 'trader') {
                                                                                                        echo "true";
                                                                                                      } else {
                                                                                                        echo "false";
                                                                                                      } ?>" aria-controls="trader">
              <a class="nav-link <?php if ($show == 'trader') {
                                    echo "active";
                                  } ?>" href="./admin-trader.php">
                <span data-feather="shopping-cart"></span>
                Trader
              </a>
            </button>
          </h5>
        </div>
        <div id="trader" class="collapse <?php if ($show == 'trader') {
                                            echo "show";
                                          } ?>" aria-labelledby="traderHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./admin-trader.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'trader-details') {
                                                                                            echo "active";
                                                                                          } ?>">
                Trader Details
              </a>
            </div>
          </div>
        </div>
      </div>

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
                                  } ?>" href="./admin-trader-type.php">
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
              <a href="./admin-trader-type.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'trader-type-details') {
                                                                                                  echo "active";
                                                                                                } ?>">
                Trader Type Details
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="collectionSlotHeader">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collectionSlot" aria-expanded="<?php if ($show == 'collectionSlot') {
                                                                                                                echo "true";
                                                                                                              } else {
                                                                                                                echo "false";
                                                                                                              } ?>" aria-controls="collectionSlot">
              <a class="nav-link <?php if ($show == 'collectionSlot') {
                                    echo "active";
                                  } ?>" href="./admin-collection-slot.php">
                <span data-feather="user"></span>
                Collection Slot
              </a>
            </button>
          </h5>
        </div>
        <div id="collectionSlot" class="collapse <?php if ($show == 'collectionSlot') {
                                                    echo "show";
                                                  } ?>" aria-labelledby="collectionSlotHeader" data-parent="#accordion">
          <div class="card-body">
            <div class="list-group">
              <a href="./admin-collection-slot.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'collection-slot-details') {
                                                                                                      echo "active";
                                                                                                    } ?>">
                Collection Slot Details
              </a>
              <a href="./admin-add-collection-slot.php" class="list-group-item list-group-item-action  <?php if ($sub_show == 'add-collection-slot') {
                                                                                                          echo "active";
                                                                                                        } ?>">
                Add Collection Slots
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