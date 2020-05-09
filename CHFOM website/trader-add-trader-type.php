<?php
session_start();

if (isset($_SESSION['user'])) {
    if (!empty($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == "TRADER") {
        $user = $_SESSION['user'];
    } else {
        $_SESSION['failure_message'] = "You don't have permissions to view this page.";
        header('Location: http://localhost/login.php');
    }
} else {
    $_SESSION['failure_message'] = "You don't have permissions to view this page.";
    header('Location: http://localhost/login.php');
}


@include("includes/header.php");
?>

<body>
    <style>
    </style>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-3">
        <div class="container-lg container-fluid">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="trader_type">Trader Type</label>
                    <input type="text" class="form-control" name="trader_type" placeholder="Enter a trader type for business">
                    <small class="text-info">This will be approved only if this product type doesn't match / co-incide with current types.</small>
                </div>
                <div class="form-group">
                    <label for="trader_description">Trader Description</label>
                    <textarea class="form-control" name="trader_description" rows="10" placeholder="Enter the description for the trader type"></textarea>
                </div>
            </form>
        </div>
    </section>
    <?php
    @include("includes/nav-footer.php");
    ?>
</body>

<?php
@include("includes/footer.php");
?>