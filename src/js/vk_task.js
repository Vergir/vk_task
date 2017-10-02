function change_sorting(params) {
    location.href = 'show_products.php?params='+params;
}

function close_modal(modal) {
    $(modal).css('display', 'none');
}

function show_modal(modal) {
    $(modal).css('display', 'block');
}

function delete_product(id) {
    if (confirm("Are you sure you want to delete product #" + id + "?") != true) {
        return;
    }
    
    $.ajax({
      type: "POST",
      url: "delete_product.php",
      data: {
        'id': id,
      },
      success: function (result) {
        strings = result.split("|");
        status = strings[0];
        user_message = strings[1];

        if (status == "success") {
           $("#product"+id).fadeOut(); 
        } else {
            alert(user_message);
        }
      },
      error: function (error) {
          console.log(error);
      }
    });
}

function confirm_create() {
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

        if (result == '') {
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
