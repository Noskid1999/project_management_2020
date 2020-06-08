$("#results-filter-toggle").click(function () {
  document.getElementById("switch-success").checked = !document.getElementById(
    "switch-success"
  ).checked;
  var filterChecked = $("#switch-success").is(":checked");

  if (filterChecked) {
    // $("#prod-filter").css("left", "0");
    $("#prod-filter").addClass("left-0");

    // $("#prod-filter").css("display", "block");
    if (window.innerWidth > 1200) {
      $("#prod-data").css("flex", "0 0 83.333333%");
      $("#prod-data").css("max-width", "83.333333%");
      $("#prod-data").css("margin-left", "16.666667%");
    }
  } else {
    // $("#prod-filter").css("left", "-100%");
    $("#prod-filter").removeClass("left-0");

    // $("#prod-filter").css("display", "none");

    $("#prod-data").css("flex", "0 0 100%");
    $("#prod-data").css("max-width", "100%");

    $("#prod-data").css("margin-left", "0%");
  }
});

if (window.innerWidth < 400) {
  $("#prod-filter").removeClass("col-2");
}
if (window.innerWidth < 1200) {
  $("#prod-filter").css("position", "absolute");
  $("#prod-filter").css("z-index", "97");
}
$("#search_param").on("input", function (e) {
  var search_param = $("#search_param").val();
  var payload = {
    action: "fetch_data",
    search_param: search_param,
  };
  create_filter_output_search(payload);
});
function create_filter_output_search(payload) {
  // $(".loading").removeClass("d-none");
  $.ajax({
    url: "api/fetch-data.php",
    method: "POST",
    data: payload,
    success: function (data) {
      // $(".loading").addClass("d-none");
      $(".search-modal #search-output").html(data);
    },
  });
}
