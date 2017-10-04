function reset_border(element) {
    $(element).css('border','1px solid grey');
}
function validate_product_fields(product) {
    var name, price, img, desc;

    if (product == null) { 
        name  = $(".create-input-name");
        price = $(".create-input-price");
        img   = $(".create-input-img");
        desc  = $(".create-input-desc");
    } else {
        name  = product.find(".product-input-name");
        price = product.find(".product-input-price");
        img   = product.find(".product-input-img");
        desc  = product.find(".product-input-desc");
    }

    validation_passed = true;

    if (!$(name).val() || $(name).val().length > 1000) {
        $(name).css('border', '1px solid red');
        validation_passed = false;
    }
    if ( !$.isNumeric($(price).val()) || $(price).val().length > 10 || $(price).val() < 0.0) {
        $(price).css('border', '1px solid red');
        validation_passed = false;
    }
    if ($(img).val().length > 2000) {
        $(img).css('border', '1px solid red');
        validation_passed = false;
    }
    if ($(desc).val().length > 2000) {
        $(desc).css('border', '1px solid red');
        validation_passed = false;
    }

    return validation_passed;
}

function close_create_modal() {
    $(".create-modal").css('display', 'none');
    reset_border($(".create-input-name"));
    $(".create-input-name").val('');

    reset_border($(".create-input-price"));
    $(".create-input-price").val('');

    reset_border($(".create-input-img"));
    $(".create-input-img").val('');

    reset_border($(".create-input-desc"));
    $(".create-input-desc").val('');

}

function show_create_modal() {
    $(".create-modal").css('display', 'block');
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
        reset_border(this);
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
    product.find(".product-input-img").val(product.find(".product-img-tag").attr('data-src'));
    product.find(".product-img-tag").attr('src', 'resources/question.png');
}

function save_edit(id) {
    var product = $("#edit"+id).parents(".product");
    if (!validate_product_fields(product)) {
        return;
    }

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
    if (!validate_product_fields()) {
        return;
    }


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

    close_create_modal();
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
