function generate_pagination(current_page, total_num_data, page_links = 5) {
  current_page = parseInt(current_page);
  if (total_num_data < 1) {
    return null;
  }

  var html = "";
  if (current_page <= 1) {
    html +=
      '<li class=" page-item disabled"><a href="#!" class="page-link"><i class="fas fa-chevron-left"></i></a></li>';
  } else {
    html +=
      '<li class=" page-item pagination-left waves-effect"><a href="#!" class="page-link"><i class="fas fa-chevron-left"></i></a></li>';
  }

  var leeway = Math.floor(page_links / 2);

  var total_page = Math.ceil(total_num_data / 48);
  var first_page = current_page - leeway;
  var last_page = current_page + leeway;

  if (first_page < 1) {
    first_page = 1;
    last_page = first_page + page_links - 1;
  }
  if (last_page > total_page) {
    first_page = last_page - page_links - 1;
    last_page = total_page;
  }
  if (first_page < 1) {
    first_page = 1;
  }
  for (i = first_page; i <= last_page; i++) {
    if (i == current_page) {
      html +=
        '<li class="page-item active"><a href="#!" class=" page-link">' +
        i +
        "</a></li>";
    } else {
      html +=
        '<li class="page-item waves-effect"><a href="#!" class=" page-link">' +
        i +
        "</a></li>";
    }
  }
  if (current_page >= total_page) {
    html +=
      '<li class="page-item disabled"><a href="#!" class=" page-link"><i class="fas fa-chevron-right"></i></a></li>';
  } else {
    html +=
      '<li class="page-item pagination-right  waves-effect"><a href="#!" class=" page-link"><i class="fas fa-chevron-right"></i></a></li>';
  }

  $("#pagination-container").html(html);
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function get_filter(class_name) {
  var filter = [];
  $("." + class_name + ":checked").each(function () {
    filter.push($(this).val());
  });
  return filter;
}

function create_filter_output(payload) {
  $(".loading").removeClass("d-none");
  $.ajax({
    url: "api/fetch-data.php",
    method: "POST",
    data: payload,
    success: function (data) {
      $(".loading").addClass("d-none");
      $("#prod-data-output").html(data);
    },
  });
}

$(document).ready(function () {
  filter_data();

  function filter_data(offset = 0) {
    $("#prod-data-output").html('<div id="loading"></div>');
    var action = "fetch_data";
    var product_type = get_filter("product_type");
    var category = get_filter("category");
    var filter_count = 48;
    var minimum_price = $("#hidden_minimum_price").val();
    var maximum_price = $("#hidden_maximum_price").val();
    var sorting = $("#sel1").val();
    var sort_query = "Product_name";
    if (sorting == "name_asc") {
      sort_query = "Product_name";
    } else if (sorting == "name_desc") {
      sort_query = "Product_name DESC";
    } else if (sorting == "price_asc") {
      sort_query = "PRODUCT_PRICE	";
    } else if (sorting == "price_desc") {
      sort_query = "PRODUCT_PRICE	 DESC";
    }
    var payload = {
      action: action,
      product_type: product_type,
      category: category,
      filter_count: filter_count,
      minimum_price: minimum_price,
      maximum_price: maximum_price,
      offset: offset,
      sort_query: sort_query,
    };
    create_filter_output(payload);
  }
  $(document).on("click", "#pagination-container li.page-number", function () {
    $("#pagination-container li.page-number").each(function () {
      $(this).removeClass("active");
    });
    $(this).addClass("active");
    filter_data(parseInt($(this).text()));
  });
  $(document).on(
    "click",
    "#pagination-container li.pagination-right",
    function () {
      var curr_page = parseInt($("#pagination-container li.active").text()) + 1;
      filter_data(curr_page);
    }
  );
  $(document).on(
    "click",
    "#pagination-container li.pagination-left",
    function () {
      var curr_page = parseInt($("#pagination-container li.active").text()) - 1;
      filter_data(curr_page);
    }
  );
  $(".checkbox_selector").click(function () {
    filter_data();
  });
  $("#sel1").on("change", function (e) {
    filter_data();
  });
  var min = $("#hidden_minimum_price").attr("min");
  var max = $("#hidden_maximum_price").attr("max");
  $("#price_range").slider({
    range: true,
    min: 20,
    max: 2000,
    values: [20, 2000],
    step: 1,
    stop: function (event, ui) {
      $("#price_show").html(ui.values[0] + " - " + ui.values[1]);
      $("#hidden_minimum_price").val(ui.values[0]);
      $("#hidden_maximum_price").val(ui.values[1]);
      filter_data();
    },
  });
});

// Handling card click
$(document).on("click",".card[data-product-id]", function (e) {
  var product_id = e.currentTarget.dataset.productId;
  window.location = "./indv-product.php?product_id=" + product_id;
});
