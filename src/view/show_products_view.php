<?php 

function skin_product_block($product) {
    $result = <<<HTML
<div class="product">
    <div class="product-id">
        $product[0];
    </div>
    <div class="product-name">
        $product[1];
    </div>
    <div class="product-desc">
        $product[2];
    </div>
    <div class="product-price">
        $product[3];
    </div>
    <div class="product-img">
        <img class="product-img-tag" src="$product[4]">
    </div>
</div>
HTML;

    return $result;
}

function skin_product_list($data) {
    $params = $data['params'];
    $request_params = "sort=$params[sort_by]".
                      "&count=$params[count]".
                      "&start_from=$params[start_from]".
                      "&asc=$params[ascending]";
    $list = '';
    foreach ($data['products'] as $item) {
        $list .= skin_product_block($item);
    }
    
    $result = <<<HTML
<a class="load_products invisible" href="/load_products.php?$request_params">
    Next
</a>
<div class="product-list">
    $list
</div>
<img class="loader-image" src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif"></img>
HTML;

    return $result;
}


?>
