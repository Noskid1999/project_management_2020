<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "ADMIN") {
        $user = $_SESSION['user'];
    } else {
        $_SESSION['failure_message'] = "You don't have permissions to view this page.";
        header('location:../../login.php');
    }
} else {
    $_SESSION['failure_message'] = "You don't have permissions to view this page.";
    header('location:../../login.php');
}

// Import required DB controller and validations functions
require_once("../core/connection.php");
require_once("../core/validation_functions.php");
?>

<link href="public/css/dashboard.css" rel="stylesheet" />
<style>
    .form-container {
        margin-left: inherit;
        max-width: 900px;
        padding: 3rem;
        border: 1px solid #999c9f;
        border-top: 5px solid #fa0101;
        border-radius: 25px;
    }

    table.table tr:hover {
        cursor: pointer;
    }
</style>
<?php
include_once("includes/navbar.php");
?>
<div class="container-fluid">
    <div class="row position-relative">
        <?php
        $show = "collectionSlot";
        $sub_show = "add-collection-slot";
        include_once("includes/sidebar.php");
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php
            include_once("includes/hamburger.php");
            ?>

            <!-- Actual data shown start -->
            <main>
                <h2>Collection Slots</h2>
                <?php
                // For error or success messages
                    if (isset($_SESSION['add-collection-slots'])) {
                        if ($_SESSION['add-collection-slots']) {
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

                        unset($_SESSION['add-collection-slots']);
                    }
                    ?>
                <div class="container form-container" id="add-collection-slots-container">
                    <form action="./api/post-add-collection-slots.php" method="POST" id=add-collection-slots">
                        <input type="hidden" name="admin_id" value="<?php echo ($user['ADMIN_ID']); ?>">
                        <label for="Days">
                            <h6>Choose days for the collection slots:</h6>
                        </label><br>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="0" class="form-check-input" id="ckb-sunday">
                            <label for="ckb-sunday">Sunday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="1" class="form-check-input" id="ckb-monday">
                            <label for="ckb-monday">Monday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="2" class="form-check-input" id="ckb-tuesday">
                            <label for="ckb-tuesday">Tuesday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="3" class="form-check-input" id="ckb-wednesday">
                            <label for="ckb-wednesday">Wednesday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="4" class="form-check-input" id="ckb-thursday">
                            <label for="ckb-thursday">Thursday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="5" class="form-check-input" id="ckb-friday">
                            <label for="ckb-friday">Friday</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="days[]" multiple value="6" class="form-check-input" id="ckb-saturday">
                            <label for="ckb-saturday">Saturday</label>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6" id="time-container">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="start_time">Start Time</label>
                                            <input type="text" name="start_time[]" multiple class="form-control" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="end_time">End Time</label>
                                            <input type="text" name="end_time[]" multiple class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" id="add-time">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="numDays">Number of Days:</label>
                            <input type="number" min="1" value="1" class="form-control" name="num-days">
                        </div>
                        <div class="form-group">
                            <label for="maxOrders">Maximum Orders:</label>
                            <input type="number" min="1" value="1" class="form-control" name="max-orders">
                        </div>
                        <button class="btn btn-primary" type="submit">Add Collection Slots</button>
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
<script>
    // Generetor for the start and end time field
    $("#add-time").on("click", function() {
        $("#time-container").append(`<div class="row">
                                        <div class="col-6 form-group">
                                            <label for="start_time">Start Time</label>
                                            <input type="text" name="start_time[]" multiple class="form-control" required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="end_time">End Time</label>
                                            <input type="text" name="end_time[]" multiple class="form-control" required>
                                        </div>
                                    </div>`);
    })
</script>
<?php
@include("includes/footer.php");
?>