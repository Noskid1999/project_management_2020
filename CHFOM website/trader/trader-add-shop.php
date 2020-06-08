<?php
session_start();
include("includes/header.php");
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['USER_TYPE'] == "TRADER") {
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

<body>

    <link href="../public/css/trader-dashboard.css" rel="stylesheet" />
    <link href="./public/css/trader-shop.css" rel="stylesheet" />
    <?php
    include_once("includes/trader-navbar.php");
    ?>

    <div class="container-fluid">
        <div class="row position-relative">
            <?php
            $show = "shops";
            $sub_show = "add-shop";
            include_once("includes/trader-sidebar.php");
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                include_once("includes/trader-hamburger.php");
                ?>
                <!-- Actual data shown start -->
                <main>
                    <h2>Add Shops</h2>
                    <div class="container form-container" id="add-shop-form-container">
                        <form action="./api/post-add-shop.php" method="POST" id="add-shop-form">
                            <div class="form-group">
                                <label for="trader-type-id">Shop Type:</label>
                                <select name="trader-type-id" id="trader-type-id" class="form-control" required>
                                    <option disabled selected style="color: #80969F;">Select the shop type</option>
                                    <!-- value = Trader_type_id && text = Trader_type -->
                                    <?php
                                    $sql = "SELECT * FROM TRADER_TYPE WHERE TRADER_ID = " . $_SESSION['user']['TRADER_ID'];
                                    $res = $db->execFetchAll($sql, "SELECT trader_type");
                                    if (count($res) > 0) {
                                        foreach ($res as $row) {
                                            echo ("<option value='" . $row['TRADER_TYPE_ID'] . "'>" . $row['TRADER_TYPE'] . "</option>");
                                        }
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shop-name">Shop Name</label>
                                <input type="text" name="shop-name" class="form-control" id="shop-name" placeholder="Enter the shop name" required>
                            </div>
                            <div class="form-group">
                                <label for="shop-description">Shop Description</label>
                                <textarea name="shop-description" id="shop-description" cols="30" rows="10" class="form-control" required></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Shop</button>
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

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        // // used for example purposes function getRandomIntInclusive(min, max) {
        // min = Math.ceil(min); max = Math.floor(max); return Math.floor(Math.random()
        // * (max - min + 1)) + min; } // create initial empty chart var ctx_live =
        // document.getElementById("mycanvas"); var myChart = new Chart(ctx_live, {
        // type: 'bar', data: { labels: [], datasets: [{ data: [], borderWidth: 1,
        // borderColor:'#00c0ef', label: 'liveCount', }] }, options: { responsive:
        // true, title: { display: true, text: "Chart.js - Dynamically Update Chart Via
        // Ajax Requests", }, legend: { display: false }, scales: { yAxes: [{ ticks: {
        // beginAtZero: true, } }] } } }); // this post id drives the example data var
        // postId = 1; // logic to get new data var getData = function() { $.ajax({
        // url: 'https://jsonplaceholder.typicode.com/posts/' + postId + '/comments',
        // success: function(data) { // process your data to pull out what you plan to
        // use to update the chart // e.g. new label and a new data point // add new
        // label and data point to chart's underlying data structures
        // if(myChart.data.labels.length >=10){ myChart.data.labels.shift();
        // myChart.data.datasets[0].data.shift();} myChart.data.labels.push("Post " +
        // postId++); myChart.data.datasets[0].data.push(getRandomIntInclusive(1, 25));
        // // re-render the chart myChart.update(); } }); }; // get new data every 3
        // seconds setInterval(getData, 3000);
        // var ctx = document.getElementById("myChart");
        // var myChart = new Chart(ctx, {
        //     type: "line",
        //     data: {
        //         labels: [
        //             "Sunday",
        //             "Monday",
        //             "Tuesday",
        //             "Wednesday",
        //             "Thursday",
        //             "Friday",
        //             "Saturday",
        //         ],
        //         datasets: [{
        //             data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
        //             lineTension: 0,
        //             backgroundColor: "transparent",
        //             borderColor: "#007bff",
        //             borderWidth: 4,
        //             pointBackgroundColor: "#007bff",
        //         }, ],
        //     },
        //     options: {
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     beginAtZero: false,
        //                 },
        //             }, ],
        //         },
        //         legend: {
        //             display: false,
        //         },
        //     },
        // });
    </script>

    <?php
    @include("includes/footer.php");
    ?>