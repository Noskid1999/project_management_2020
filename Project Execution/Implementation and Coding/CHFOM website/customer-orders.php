<?php
session_start();
if (isset($_SESSION['user'])) {
    if (!empty($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == "CUSTOMER") {
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
                                <li><a href="customer-profile.php" class="text-info">Manage My Account</a></li>
                                <li><a href="customer-orders.php" class="text-info font-weight-bold">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mt-3">
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
                                $index++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    @include("includes/nav-footer.php");
    ?>
</body>

<?php
@include("includes/footer.php");
?>