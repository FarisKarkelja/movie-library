$(document).ready(function () {
  $(".contact-form").on("submit", function (e) {
    e.preventDefault();
    toastr.success("Your message has been sent!");
    $(this)[0].reset();
  });
});
