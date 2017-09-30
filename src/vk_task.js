var isPreviousEventComplete = true,
    isDataAvailable = true

$(window).scroll(function () {
 if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
  if (isPreviousEventComplete && isDataAvailable) {
   
    isPreviousEventComplete = false;
    //$(".LoaderImage").css("display", "block");

    $.ajax({
      type: "GET",
      url: $(".load_products").attr("href"),
      success: function (result) {
        isPreviousEventComplete = true;
        //$(".LoaderImage").css("display", "none");

        if (result == '') { //When data is not available
            isDataAvailable = false;
            return;
        }

        var elements = result.split("|");
        $(".load_products").attr("href", elements[0]);
        $(".product-list").append(elements[1]);

      },
      error: function (error) {
          console.log(error);
      }
    });}}});
