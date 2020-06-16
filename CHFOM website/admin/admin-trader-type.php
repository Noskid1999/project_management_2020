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
<?php
include_once("includes/navbar.php");
?>
<div class="container-fluid">
    <div class="row position-relative">
        <?php
        $show = "trader-type";
        $sub_show = "trader-type-details";
        include_once("includes/sidebar.php");
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php
            include_once("includes/hamburger.php");
            ?>
            <!-- Actual data shown start -->
            <main>
                <h2>Trader Type</h2>
                <?php
                if (isset($_SESSION['update-trader-type'])) {
                    if ($_SESSION['update-trader-type']) {
                        echo ("
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Trader Type Updated successfully
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>");
                    } else {
                        echo ("
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Trader Type Update Unsuccessful
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                    }

                    unset($_SESSION['update-trader-type']);
                }
                ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Trader Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Trader Type</th>
                            <th scope="col">Trader Description</th>
                            <th scope="col">Approved</th>
                            <th scope="col">Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                        * 
                                    FROM 
                                        trader_type tt, trader t, users u
                                    WHERE tt.Trader_id = t.Trader_id AND
                                    t.User_id = u.User_id
                                    ORDER BY tt.Trader_type_id DESC";
                        $res = $db->execFetchAll($sql, "SELECT trader_type");
                        if (count($res) > 0) {
                            foreach ($res as $trader_type) {
                                echo ("<tr data-trader_type_id = '$trader_type[TRADER_TYPE_ID]'>");

                                echo ("<td>$trader_type[FIRST_NAME] $trader_type[LAST_NAME]</td>");
                                echo ("<td>$trader_type[EMAIL]</td>");
                                echo ("<td>$trader_type[TRADER_TYPE]</td>");
                                echo ("<td>$trader_type[DESCRIPTION] </td>");
                                echo ("<td>$trader_type[APPROVED]</td>");
                                echo (" <td>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <button class = 'btn btn-success approve-trader-type-btn' data-trader_type_id='$trader_type[TRADER_TYPE_ID]' data-admin_id = '$user[ADMIN_ID]'>
                                                        Approve
                                                    </button>
                                                </div>
                                                <div class='col-6'>
                                                <button class = 'btn btn-danger reject-trader-type-btn' data-trader_type_id='$trader_type[TRADER_TYPE_ID]' data-admin_id = '$user[ADMIN_ID]'>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </td>");
                                echo ("</tr>");
                            }
                        }

                        ?>
                    </tbody>
                </table>
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
    // Approval / Rejection button listener
    $(".approve-trader-type-btn").on("click", function(event) {
        var trader_type_id = event.target.dataset.trader_type_id;
        var admin_id = event.target.dataset.admin_id;
        var status = "Y";
        var payload = {
            trader_type_id: trader_type_id,
            admin_id: admin_id,
            status: status
        }
        $.ajax({
            method: "POST",
            url: "./api/post-update-trader-type-status.php",
            data: payload,
            success: function(data) {   
                console.log(data);
                             
                data = JSON.parse(data);
                if (data.success) {
                    window.location = window.location;
                }
            }
        })

    });
    $(".reject-trader-type-btn").on("click", function(event) {
        var trader_type_id = event.target.dataset.trader_type_id;
        var admin_id = event.target.dataset.admin_id;
        var status = "N";
        var payload = {
            trader_type_id: trader_type_id,
            admin_id: admin_id,
            status: status
        }
        $.ajax({
            method: "POST",
            url: "./api/post-update-trader-type-status.php",
            data: payload,
            success: function(data) {
                data = JSON.parse(data);
                if (data.success) {
                    window.location = window.location;
                }
            }
        })

    });
</script>
<?php
@include("includes/footer.php");
?>