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
        $show = "collectionSlot";
        $sub_show = "collection-slot-details";
        include_once("includes/sidebar.php");
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php
            include_once("includes/hamburger.php");
            ?>

            <!-- Actual data shown start -->
            <main>
                <h2>Collection Slots</h2>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Collection Slot ID</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Maximum Orders</th>
                            <th scope="col">Remaining Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                        cs.*,a.*,u.*,TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI') START_TIME,TO_CHAR(END_TIME,'YYYY-MM-DD HH24:MI') END_TIME
                                    FROM 
                                        collection_slot cs, admin a, users u
                                    WHERE cs.Added_by = a.Admin_id
                                    AND a.User_id = u.User_id
                                    ORDER BY cs.Collection_slot_id DESC";
                        $res = $db->execFetchAll($sql, "SELECT collection_slot");
                        if (count($res) > 0) {
                            foreach ($res as $collection_slot) {
                                echo (" <tr data-collection_slot_id = '$collection_slot[COLLECTION_SLOT_ID]'>
                                            <td>$collection_slot[COLLECTION_SLOT_ID]</td>
                                            <td>$collection_slot[START_TIME]</td>
                                            <td>$collection_slot[END_TIME]</td>
                                            <td>$collection_slot[FIRST_NAME] $collection_slot[LAST_NAME]</td>
                                            <td>$collection_slot[MAXIMUM_ORDERS]</td>
                                            <td>$collection_slot[REMAINING_ORDERS]</td>
                                        </tr>");
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
</script>
<?php
@include("includes/footer.php");
?>