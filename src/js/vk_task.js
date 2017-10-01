function change_sorting(params) {
    location.href = 'show_products.php?params='+params;
}

function close_create_modal_click() {
    $(".create-modal").css('display', 'none');
}

function create_button_click() {
    $(".create-modal").css('display', 'block');
}

function confirm_create_click() {
    $(".create-modal").css('display', 'none');

    $.ajax({
      type: "POST",
      url: "add_product.php",
      data: {
        'name': $(".create-input-name").val(),
        'price': $(".create-input-price").val(),
        'img': $(".create-input-img").val(),
        'desc': $(".create-input-desc").val(),
      },
      success: function (result) {
        alert(result);
        $(".create-input-name").val('');
        $(".create-input-price").val('');
        $(".create-input-img").val('');
        $(".create-input-desc").val('');
      },
      error: function (error) {
          console.log(error);
      }
    });
}

var isPreviousEventComplete = true, isDataAvailable = true;

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
      }
    });
  }
 }
});
