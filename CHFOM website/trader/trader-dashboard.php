<?php
session_start();
include("includes/header.php");
?>

<body>

  <link href="../public/css/trader-dashboard.css" rel="stylesheet" />
  <?php
  include_once("./includes/trader-navbar.php");
  ?>

  <div class="container-fluid">
    <div class="row position-relative">
      <?php
      $show = "dashboard";
      include_once("includes/trader-sidebar.php");
      ?>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
        include_once("includes/trader-hamburger.php");
        ?>
        <!-- Actual data shown start -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button class="btn btn-sm btn-outline-secondary">Share</button>
              <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

        <h2>Section title</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1,001</td>
                <td>Lorem</td>
                <td>ipsum</td>
                <td>dolor</td>
                <td>sit</td>
              </tr>
              <tr>
                <td>1,002</td>
                <td>amet</td>
                <td>consectetur</td>
                <td>adipiscing</td>
                <td>elit</td>
              </tr>
              <tr>
                <td>1,003</td>
                <td>Integer</td>
                <td>nec</td>
                <td>odio</td>
                <td>Praesent</td>
              </tr>
              <tr>
                <td>1,003</td>
                <td>libero</td>
                <td>Sed</td>
                <td>cursus</td>
                <td>ante</td>
              </tr>
              <tr>
                <td>1,004</td>
                <td>dapibus</td>
                <td>diam</td>
                <td>Sed</td>
                <td>nisi</td>
              </tr>
              <tr>
                <td>1,005</td>
                <td>Nulla</td>
                <td>quis</td>
                <td>sem</td>
                <td>at</td>
              </tr>
              <tr>
                <td>1,006</td>
                <td>nibh</td>
                <td>elementum</td>
                <td>imperdiet</td>
                <td>Duis</td>
              </tr>
              <tr>
                <td>1,007</td>
                <td>sagittis</td>
                <td>ipsum</td>
                <td>Praesent</td>
                <td>mauris</td>
              </tr>
              <tr>
                <td>1,008</td>
                <td>Fusce</td>
                <td>nec</td>
                <td>tellus</td>
                <td>sed</td>
              </tr>
              <tr>
                <td>1,009</td>
                <td>augue</td>
                <td>semper</td>
                <td>porta</td>
                <td>Mauris</td>
              </tr>
              <tr>
                <td>1,010</td>
                <td>massa</td>
                <td>Vestibulum</td>
                <td>lacinia</td>
                <td>arcu</td>
              </tr>
              <tr>
                <td>1,011</td>
                <td>eget</td>
                <td>nulla</td>
                <td>Class</td>
                <td>aptent</td>
              </tr>
              <tr>
                <td>1,012</td>
                <td>taciti</td>
                <td>sociosqu</td>
                <td>ad</td>
                <td>litora</td>
              </tr>
              <tr>
                <td>1,013</td>
                <td>torquent</td>
                <td>per</td>
                <td>conubia</td>
                <td>nostra</td>
              </tr>
              <tr>
                <td>1,014</td>
                <td>per</td>
                <td>inceptos</td>
                <td>himenaeos</td>
                <td>Curabitur</td>
              </tr>
              <tr>
                <td>1,015</td>
                <td>sodales</td>
                <td>ligula</td>
                <td>in</td>
                <td>libero</td>
              </tr>
            </tbody>
          </table>
        </div>
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
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ],
        datasets: [{
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "#007bff",
          borderWidth: 4,
          pointBackgroundColor: "#007bff",
        }, ],
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false,
            },
          }, ],
        },
        legend: {
          display: false,
        },
      },
    });
  </script>

  <?php
  @include("includes/footer.php");
  ?>