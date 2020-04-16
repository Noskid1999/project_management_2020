$(document).on("click", "button.navbar-toggler", () => {
  $(".side-navbar").addClass("show");
});
$(document).on("click", "i.close-sidebar", () => {
  $(".side-navbar").removeClass("show");
});
$(document).on("mousewheel", function() {
  var added_true = false;

  if ($(document).scrollTop() > 0 && !added_true) {
    $(".navbar").addClass("shadow-sm");
    add_nav_box_shadow = false;
    added_true = true;
  } else {
    $(".navbar").removeClass("shadow-sm");
    add_nav_box_shadow = true;
    added_true = false;
  }
});
