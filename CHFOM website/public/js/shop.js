function generate_pagination(current_page, page_links = 5) {
  current_page = parseInt(current_page);
  var total_num_data = 50;
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
generate_pagination(1);
