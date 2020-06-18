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
print_r($_POST);
?>

<body>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-3">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12 border border-secondary">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <span class="text-info">
                                Basket
                            </span>
                        </div>
                        <div class="col-12 mb-2">
                            <h4>Basket Details: <span class="text-orange">#123123123</span></h4>
                        </div>
                        <div class="col-12 mb-3">
                            <span class="border border-secondary p-2 text-info border-rounder-1_5">Details</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h5>Bill To:</h5>
                        </div>
                        <div class="col-12 text-small">
                            <span> <i class="fab fa-facebook-f mr-2 text-info"></i>Lorem Ipsum</span>
                        </div>
                        <div class="col-12 text-small">
                            <span> <i class="fab fa-facebook-f mr-2 text-info"></i>123456789</span>
                        </div>
                        <div class="col-12 text-small">
                            <span> <i class="fab fa-facebook-f mr-2 text-info"></i>test@test.com</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Unit Cost</th>
                                <th scope="col">Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                            ?>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Item 1</td>
                                    <td>Lorem ipsum dolor sit amet.</td>
                                    <td>1</td>
                                    <td>£500</td>
                                    <td>£500</td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-7">
                    <h4>Note:</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit earum odit numquam deserunt est corrupti error! Autem reiciendis, nam a ratione quaerat facilis voluptatibus quia?</p>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-12 text-large">
                            <div class=" float-right"><span class="text-small">Sub-total:</span>£2500</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-large">
                            <div class="float-right"><span class="text-small">Sub-total:</span>£2500</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-large">
                            <div class="float-right"><span class="text-small">Sub-total:</span>£2500</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-large">
                            <div class="float-right"><span class="text-small">Sub-total:</span>£2500</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-large">
                            <div class="float-right">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-end">
                                        <button class="border border-secondary border-rounder-1_5 p-1 pl-3 pr-2 float-left mr-2 bg-white">
                                            <i class="fab fa-facebook-f mr-2 text-info"></i>
                                        </button>
                                        <button class="border border-rounder-1_5 p-2 pl-3 pr-2 float-left bg-orange">
                                            <span class=" text-white">Proceed To Checkout</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
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