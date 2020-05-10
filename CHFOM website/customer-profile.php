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
                                <li><a href="" class="text-info">Manage My Account</a></li>
                                <li><a href="" class="text-info">My Orders</a></li>
                                <li><a href="" class="text-info">My Reviews</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mt-3">
                    <div class="row">
                        <div class="col-12">
                            <h3>Manage My Account</h3>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 py-1">
                            <div class=" bg-white border border-secondary p-2 w-100 h-100" style="overflow-wrap: anywhere;">
                                <h5>Personal Profile | <span><a href="" class="text-decoration-none text-info">Edit</a></span></h5>
                                <span><?php echo ($user["FIRST_NAME"] . " " . $user["LAST_NAME"]); ?></span>
                                <span><?php echo ($user["EMAIL"]); ?></span>
                            </div>
                        </div>
                        <div class="col-lg-8 py-1">
                            <div class=" bg-white border border-secondary p-2 w-100 h-100">
                                <h5>Address Book | <span><a href="" class="text-decoration-none text-info">Edit</a></span></h5>
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
                                <th scope="col">Status</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">#1</td>
                                    <td>04/22/2020</td>
                                    <td><img src="public/img/products/test.jpg" alt="Item 1" width="80px"> Item 1</td>
                                    <td>€500</td>
                                    <td>Ordered</td>
                                </tr>
                                <tr>
                                    <th scope="row">#1</td>
                                    <td>04/22/2020</td>
                                    <td><img src="public/img/products/test.jpg" alt="Item 1" width="80px"> Item 1</td>
                                    <td>€500</td>
                                    <td>Ordered</td>
                                </tr>
                                <tr>
                                    <th scope="row">#1</td>
                                    <td>04/22/2020</td>
                                    <td><img src="public/img/products/test.jpg" alt="Item 1" width="80px"> Item 1</td>
                                    <td>€500</td>
                                    <td>Ordered</td>
                                </tr>
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