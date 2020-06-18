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
        $show = "trader";
        $sub_show = "trader-details";
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
                if (isset($_SESSION['update-trader'])) {
                    if ($_SESSION['update-trader']) {
                        echo ("
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Trader Updated successfully
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>");
                    } else {
                        echo ("
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Trader Update Unsuccessful
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>");
                    }

                    unset($_SESSION['update-trader']);
                }
                ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Trader Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">VAT Registration Number</th>
                            <th scope="col">Proposal Accepted</th>
                            <th scope="col">Change Status</th>
                            <th scope="col">Trader Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                        * 
                                    FROM 
                                        trader t, users u
                                    WHERE
                                        t.User_id = u.User_id
                                    ORDER BY Trader_id DESC";
                        $res = $db->execFetchAll($sql, "SELECT trader");
                        if (count($res) > 0) {
                            foreach ($res as $trader) {
                                echo ("<tr data-trader_id = '$trader[TRADER_ID]'>");

                                echo ("<td>$trader[FIRST_NAME] $trader[LAST_NAME]</td>");
                                echo ("<td>$trader[EMAIL]</td>");
                                echo ("<td>$trader[VAT_REGISTRATION_NUMBER] </td>");
                                echo ("<td>$trader[PROPOSAL_ACCEPTED]</td>");
                                echo (" <td>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <button class = 'btn btn-success approve-trader-btn' data-trader_id='$trader[TRADER_ID]' data-admin_id = '$user[ADMIN_ID]'>
                                                        Approve
                                                    </button>
                                                </div>
                                                <div class='col-6'>
                                                <button class = 'btn btn-danger reject-trader-btn' data-trader_id='$trader[TRADER_ID]' data-admin_id = '$user[ADMIN_ID]'>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </td>");
                                echo ("<td>
                                            <form action = 'api/post-admin-trader-access.php' method='POST'>
                                                <input type='hidden' name='trader_id' value='$trader[TRADER_ID]'>
                                                <input type='hidden' name='admin_id' value='$user[ADMIN_ID]'>
                                                <button class = 'btn btn-warning trader-access-btn' type='submit' data-trader_id='$trader[TRADER_ID]' data-admin_id = '$user[ADMIN_ID]'>
                                                Trader Access</button>
                                            </form>
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
    // Button listener for the approval/ reject of the trader status
    $(".approve-trader-btn").on("click", function(event) {
        var trader_id = event.target.dataset.trader_id;
        var admin_id = event.target.dataset.admin_id;
        var status = "Y";
        var payload = {
            trader_id: trader_id,
            admin_id: admin_id,
            status: status
        }
        $.ajax({
            method: "POST",
            url: "./api/post-update-trader-status.php",
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
    $(".reject-trader-btn").on("click", function(event) {
        var trader_id = event.target.dataset.trader_id;
        var admin_id = event.target.dataset.admin_id;
        var status = "N";
        var payload = {
            trader_id: trader_id,
            admin_id: admin_id,
            status: status
        }
        $.ajax({
            method: "POST",
            url: "./api/post-update-trader-status.php",
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