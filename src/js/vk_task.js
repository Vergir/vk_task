function close_modal(modal) {
    $(modal).css('display', 'none');
}

function show_modal(modal) {
    $(modal).css('display', 'block');
}

function click_delete(id) {
    if ($("#edit"+id).css('display') == 'block') {
        delete_product(id);
    } else {
        cancel_edit(id);
    }
}

function cancel_edit(id) {
    $("#edit"+id).css('display','block');
    $("#confirm"+id).css('display','none');
    var product = $("#edit"+id).parents(".product");

    product.find(".product-input").each(function() {
        $(this).val(($.trim($(this).next("span").text())));
        $(this).next("span").css('display','inline');
        $(this).css('display','none');
    });
    product.find(".product-field-img").css('display','none');
    product.find(".product-img-tag").attr('src', product.find(".product-img-tag").attr('data-src'));
    product.find(".product-delete-tag").attr('src','/resources/delete.png');
}

function start_edit(id) {
    product = $("#edit"+id).parents(".product");

    $("#edit"+id).css('display','none');
    $("#confirm"+id).css('display','block');
    product.find(".product-delete-tag").attr('src','/resources/delete-black.png');

    product.find(".product-input").each(function() {
        $(this).val(($.trim($(this).next("span").text())));
        $(this).next("span").css('display','none');
        $(this).css('display','inline');
    });

    product.find(".product-field-img").css('display','block');
    product.find(".product-img-tag").attr('src', 'resources/question.png');
    
}

function save_edit(id) {
    var product = $("#edit"+id).parents(".product");

    $.ajax({
      type: "POST",
      url: "update_product.php",
      data: {
        'old_id': id,
        'name': product.find(".product-input-name").val(),
        'price': product.find(".product-input-price").val(),
        'img': product.find(".product-input-img").val(),
        'desc': product.find(".product-input-desc").val(),
      },
      success: function (result) {
        if (result == "success") {
            product.find(".product-label").each(function() {
                $(this).text(($(this).prev(".product-input").val()));
                $(this).prev(".product-input").css('display','none');
                $(this).css('display','inline');
            });
            product.find(".product-field-img").css('display','none');
            product.find(".product-img-tag").attr('data-src', product.find(".product-input-img").val());
            product.find(".product-img-tag").attr('src', product.find(".product-input-img").val());
            product.find(".product-delete-tag").attr('src','/resources/delete.png');

            $("#edit"+id).css('display','block');
            $("#confirm"+id).css('display','none');

        } else {
            alert(result);
        }
      },
      error: function (error) {
          console.log(error);
      }
    });
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

$(function() {
    $('.sorting-select').on('change', function() {
        location.href = 'show_products.php?params='+this.value;
    })
});
