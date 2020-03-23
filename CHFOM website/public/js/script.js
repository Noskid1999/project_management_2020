$(document).on("click", "button.navbar-toggler", () => {
  $(".side-navbar").addClass("show");
});
$(document).on("click", "i.close-sidebar", () => {
  $(".side-navbar").removeClass("show");
});
$(document).on("mousewheel", function() {
  var add_nav_box_shadow = true;
  var added_true = false;

  if ($(document).scrollTop()) {
    add_nav_box_shadow = true;
  } else {
    add_nav_box_shadow = false;
  }
  if (add_nav_box_shadow && !added_true) {
    $(".navbar").addClass("shadow-sm");
    add_nav_box_shadow = false;
    added_true = true;
  } else {
    $(".navbar").removeClass("shadow-sm");
    add_nav_box_shadow = true;
    added_true = false;
  }
});
