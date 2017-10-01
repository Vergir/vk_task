function change_sorting(params) {
    location.href = 'show_products.php?params='+params;
}

var isPreviousEventComplete = true,
    isDataAvailable = true

$(window).scroll(function () {
 if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
  if (isPreviousEventComplete && isDataAvailable) {
   
    isPreviousEventComplete = false;
    $(".loader-image").css("display", "block");

    $.ajax({
      type: "GET",
      url: $(".load_products").attr("href"),
      success: function (result) {
        isPreviousEventComplete = true;
        $(".loader-image").css("display", "none");

        if (result == '') { //When data is not available
            isDataAvailable = false;
            return;
        }

        var elements = result.split("|", 2);
        $(".load_products").attr("href", elements[0]);
        $(".product-list").append(elements[1]);

      },
      error: function (error) {
          console.log(error);
      }});}}});
