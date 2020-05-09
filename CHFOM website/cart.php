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

<body>
    <style>
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            vertical-align: middle;
        }

        @media screen and (max-width: 600px) {
            table#cart tbody td .form-control {
                width: 20%;
                display: inline !important;
            }

            .actions .btn {
                width: 36%;
                margin: 1.5em 0;
            }

            .actions .btn-info {
                float: left;
            }

            .actions .btn-danger {
                float: right;
            }

            table#cart thead {
                display: none;
            }

            table#cart tbody td {
                display: block;
                padding: .6rem;
                min-width: 320px;
            }

            table#cart tbody tr td:first-child {
                background: #80807E;
                color: #fff;
            }

            table#cart tbody td:before {
                content: attr(data-th);
                font-weight: bold;
                display: inline-block;
                width: 8rem;
            }



            table#cart tfoot td {
                display: block;
            }

            table#cart tfoot td .btn {
                display: block;
            }

        }
    </style>
    <?php
    @include("includes/navbar.php");
    ?>
    <section id="main" class="mt-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <h2>
                        Shopping Cart
                    </h2>
                </div>
            </div>
            <div class="row mt-5">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:10%">Price</th>
                            <th style="width:8%">Quantity</th>
                            <th style="width:22%" class="text-center">Subtotal</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-th="Product">
                                <div class="row align-items-center">
                                    <div class="col-sm-2 d-inline d-sm-none d-md-none d-lg-none d-xl-inline"><img src="http://placehold.it/100x100" alt="..." class=" img-fluid" /></div>
                                    <div class="col-sm-10">
                                        <h4 class="nomargin">Product 1</h4>
                                        <p>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">€1.99</td>
                            <td data-th="Quantity">
                                <input type="number" class="form-control text-center" value="1" disabled>
                            </td>
                            <td data-th="Subtotal" class="text-center">€1.99</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td data-th="Product">
                                <div class="row align-items-center">
                                    <div class="col-sm-2 d-inline d-sm-none d-md-none d-lg-none d-xl-inline"><img src="http://placehold.it/100x100" alt="..." class=" img-fluid" /></div>
                                    <div class="col-sm-10">
                                        <h4 class="nomargin">Product 1</h4>
                                        <p>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">€1.99</td>
                            <td data-th="Quantity">
                                <input type="number" class="form-control text-center" value="1" disabled>
                            </td>
                            <td data-th="Subtotal" class="text-center">€1.99</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="visible-xs">
                            <td class="text-center"><strong>Total €1.99</strong></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <td class="hidden-xs text-center"><strong>Total €1.99</strong></td>
                            <td><a href="#" class="btn btn-success btn-block">Checkout&nbsp;<i class="fa fa-angle-right d-inline"></i></a></td>
                        </tr>
                    </tfoot>
                </table>
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