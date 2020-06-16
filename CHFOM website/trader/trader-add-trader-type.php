<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
        $user = $_SESSION['user'];
    } else {
        $_SESSION['failure_message'] = "You don't have permissions to view this page.";
        header('location:../../login.php');
    }
} else {
    $_SESSION['failure_message'] = "You don't have permissions to view this page.";
    header('location:../../login.php');
}

require_once("../core/connection.php");
require_once("../core/validation_functions.php");
?>

<body>

    <link href="../public/css/trader-dashboard.css" rel="stylesheet" />
    <link href="./public/css/trader-shop.css" rel="stylesheet" />
    <?php
    include_once("includes/trader-navbar.php");
    ?>

    <div class="container-fluid">
        <div class="row position-relative">
            <?php
            $show = "trader-type";
            $sub_show = "trader-add-trader-type";
            include_once("includes/trader-sidebar.php");
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                include_once("includes/trader-hamburger.php");
                ?>
                <!-- Actual data shown start -->
                <main>
                    <h2>Add Trader Type</h2>
                    <?php
                    if (isset($_SESSION['add-trader-type-success'])) {
                        if ($_SESSION['add-trader-type-success']) {
                            echo ("
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Trader Type Added successfully
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>");
                        } else {
                            echo ("
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Trader Type Added Unsuccessful
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                        }

                        unset($_SESSION['add-trader-type-success']);
                    }
                    ?>
                    <div class="container form-container" id="add-shop-form-container">
                        <form action="api/post-add-trader-type.php" method="post">
                            <input type="hidden" name="trader_id" value="<?php echo $user['TRADER_ID'];  ?>">
                            <div class="form-group">
                                <label for="trader_type">Trader Type</label>
                                <input type="text" class="form-control" name="trader_type" placeholder="Enter a trader type for business">
                                <small class="text-info">This will be approved only if this product type doesn't match / co-incide with current types.</small>
                            </div>
                            <div class="form-group">
                                <label for="trader_description">Trader Description</label>
                                <textarea class="form-control" name="trader_description" rows="10" placeholder="Enter the description for the trader type"></textarea>
                            </div>
                            <button class="btn btn-primary">Add Trader Type</button>
                        </form>
                    </div>
                </main>
                <!-- Actual data shown end -->
            </main>
        </div>
    </div>

    <!-- Icons -->
    <script>
        function showSideBar() {
            $(".sidebar").addClass("left-0");
            $(".close i").removeClass("d-none");
            $(".close").removeClass("left-100");
        }

        function hideSideBar() {
            $(".sidebar").removeClass("left-0");
            $(".close i").addClass("d-none");
            $(".close").addClass("left-100");
        }
    </script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        
    </script>

    <?php
    @include("includes/footer.php");
    ?>