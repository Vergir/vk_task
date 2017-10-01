<?php 

function skin_product_block($product) {
    $result = <<<HTML
<div class="product">
    <div class="product-field product-img">
        <img class="product-img-tag" src="$product[4]">
    </div>
    <div class="product-field product-id">
        $product[0];
    </div>
    <div class="product-field product-name">
        $product[1];
    </div>
    <div class="product-field product-desc">
        $product[2];
    </div>
    <div class="product-field product-price">
        $product[3];
    </div>
</div>

HTML;

    return $result;
}

function skin_list_header() {
    return false;
    $fields = array(
        'img' => 'Image',
        'id' => 'ID',
        'name' => 'Name',
        'desc' => 'Description',
        'price' => 'Price');
    $headers = '';
    foreach ($fields as $col_key => $col_value) {
      $headers .= <<<HTML
<div class="product-heeader product-header-$col_key">
    $col_value
</div>

HTML;
    }

    $result = <<<HTML
<div class="product-headers">
    $headers
</div>

HTML;
    return $result;
}

function skin_product_list($data) {
    $list_header = skin_list_header();
    $list = '';
    $list_items = '';
    foreach ($data['products'] as $item) {
        $list .= skin_product_block($item);
    }
    
    $params = $data['params'];
    $request_params = "sort=$params[sort_by]".
                      "&count=$params[count]".
                      "&start_from=$params[start_from]".
                      "&asc=$params[ascending]";

    $list_items .= <<<HTML
<a class="load_products invisible" href="/load_products.php?$request_params"></a>
<div class="product-list">
    $list
</div>
<img class="loader-image" src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif"></img>
HTML;
    
    $result = <<<HTML
<div class="outer">
$list_header
$list_items
</div>

HTML;

    return $result;
}


?>
