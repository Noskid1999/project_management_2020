<?php
session_start();
if (isset($_SESSION['user'])) {
    if (!empty($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        $_SESSION['failure_message'] = "You need to login to continue.";
        header('Location: http://localhost/login.php');
    }
} else {
    $_SESSION['failure_message'] = "You need to login to continue.";
    header('Location: http://localhost/login.php');
}

require_once("./core/connection.php");
@include("includes/header.php");
?>
<link rel="stylesheet" href="public/css/indv-product.css">

<body>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-3">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class=" bg-white border border-secondary border-rounder-1_5 w-100 text-center pt-2">
                                <p>Hello,<br><?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-white border border-dark border-rounder-1_5 p-3 py-4">
                        <div class="col-12">
                            <ul class=" list-unstyled mb-0">
                                <li><a href="customer-profile.php" class="text-info font-weight-bold">Manage My Account</a></li>
                                <li><a href="customer-orders.php" class="text-info">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mt-3">
                    <div class="row">
                        <div class="col-12 d-none" id="success-alert">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Profile Update Sucess!</strong> Please relogin to view the changes.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <h3>Manage My Account</h3>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 py-1">
                            <div class=" bg-white border border-secondary p-2 w-100 h-100" style="overflow-wrap: anywhere;">
                                <h5>Personal Profile | <span><a href="" class="text-decoration-none text-info" data-toggle="modal" data-target="#profileModal">Edit</a></span></h5>
                                <span><?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?></span>
                                <span><?php echo ($user["EMAIL"]); ?></span>
                            </div>
                        </div>
                        <div class="col-lg-8 py-1">
                            <div class=" bg-white border border-secondary p-2 w-100 h-100">
                                <h5>Address Book | <span><a href="" class="text-decoration-none text-info" data-toggle="modal" data-target="#profileModal">Edit</a></span></h5>
                                <div class="row">
                                    <div class="col-sm-6 border-right border">
                                        <span class="text-secondary">Address</span><br>
                                        <span class="text-small"><b><?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?></b></span><br>
                                        <?php
                                        $address = explode(",", $user["ADDRESS"]);
                                        foreach ($address as $add) {
                                            echo ("<span class='text-small'>$add</span><br>");
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-6 border">
                                        <span class="text-secondary">Default Billing Address</span><br>
                                        <span class="text-small"><b><?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?></b></span><br>
                                        <?php
                                        $address = explode(",", $user["ADDRESS"]);
                                        foreach ($address as $add) {
                                            echo ("<span class='text-small'>$add</span><br>");
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row table-responsive">
                        <table class="table table-hover table-striped border bg-white">
                            <thead>
                                <th scope="col">Order No</th>
                                <th scope="col">Placed On</th>
                                <th scope="col">Item</th>
                                <th scope="col">Total</th>
                                <th scope="col">Delivery Status</th>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT p.*,pd.*,bp.*,i.*,b.*,c.*, TO_CHAR(bp.ADDED_TO_BASKET_TIME, 'YYYY-MM-DD HH24:MI') as req_time 
                                                FROM product p,payment_detail pd, basket_product bp, invoice i, basket b, customer c
                                                WHERE pd.Basket_product_id = bp.Basket_product_id
                                                AND pd.Invoice_id = i.Invoice_id
                                                AND (
                                                        DELIVERY_STATUS IS NULL 
                                                        OR
                                                        DELIVERY_STATUS <>'COMPLETED'
                                                    )
                                                AND bp.Basket_id=b.Basket_id
                                                AND b.Customer_id=c.Customer_id
                                                AND p.Product_id = bp.Product_id
                                                AND c.User_id = $user[USER_ID]
                                                ORDER BY Payment_detail_id DESC
                                                        ";
                                $res = $db->execFetchAll($sql, "SELECT all not delivered items");
                                $index = 1;
                                foreach ($res as $item) {
                                ?>
                                    <tr>
                                        <th scope="row">#<?php echo $item["BASKET_PRODUCT_ID"]; ?></td>
                                        <td><?php
                                            echo $item["REQ_TIME"];
                                            ?></td>
                                        <td><?php echo $item["PRODUCT_NAME"]; ?></td>
                                        <td>£<?php echo $item["PRODUCT_PRICE"]; ?></td>
                                        <td><?php echo $item["DELIVERY_STATUS"]; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile Edit Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="profile_edit-form">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" disabled id="email" class="form-control" value="<?php echo ($user["EMAIL"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="address" class="form-control" value="<?php echo ($user["ADDRESS"]); ?>">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="form_update-btn" data-id='<?php echo $user["USER_ID"]; ?>' data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    @include("includes/nav-footer.php");
    ?>
    <script>
        $("#form_update-btn").on("click", function(e) {
            var user_id = e.target.dataset.id;
            var full_name = $("#full_name").val();
            var split = full_name.split(" ");
            var f_name = split[0];
            split.shift();
            var l_name = split.join(" ");
            var address = $("#address").val();
            var email = $("#email").val();
            var payload = {
                user_id,
                f_name,
                l_name,
                address,
                email
            }
            $.ajax({
                method: "POST",
                url: "./api/customer-profile/post-update-customer-profile.php",
                data: payload,
                success: function(data) {
                    data = JSON.parse(data);
                    
                    if (data.success) {
                        $("#success-alert").removeClass("d-none");
                    }

                }
            })


        })
    </script>
</body>

<?php
@include("includes/footer.php");
?>