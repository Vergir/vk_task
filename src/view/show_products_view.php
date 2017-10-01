<?php 

function skin_create_modal() {
    $result =<<<HTML

<div class="modal create-modal">
  <div class="modal-content">
    <span class="close-modal" onclick="close_create_modal_click()">&times;</span>
    <div class="input-field-names">
        <div class="input-field-name">
            Name:
        </div>
        <div class="input-field-name">
            Price:
        </div>
        <div class="input-field-name">
            Image Source:
        </div>
        <div class="input-field-name">
            Description:
        </div>
    </div>
    <div class="input-fields">
        <div class="input-field">
            <input class="create-input-name" maxlength="100" type="text"></input>
        </div>
        <div class="input-field">
            <input class="create-input-price" maxlength="10" type="text"></input>
        </div>
        <div class="input-field">
            <input class="create-input-img" type="url"></input>
        </div>
        <div class="input-field input-field-textarea">
            <textarea class="create-input-desc" maxlength="2000"></textarea>
        </div>
    </div>
    <input class="create-confirm-button" type=submit onclick="confirm_create_click()" value="CREATE"></input>
  </div>
</div> 

HTML;

    return $result;
}

function skin_header($params) {
    $columns = array('id' => 'ID', 'price' => 'Price');
    $options = '';
    foreach ($columns as $col_key => $col_val) {
        if ($params['sort_by'] === $col_key) {
            $selected_asc = $params['ascending'] ? 'selected' : '';
            $selected_desc = !($params['ascending']) ? 'selected' : '';
        } else {
            $selected_asc = false;
            $selected_desc = false;
        }
        $options .= <<<HTML
<option onclick="change_sorting('$col_key|1')" $selected_asc>
    $col_val - Ascending
</option>
<option onclick="change_sorting('$col_key|0')" $selected_desc>
    $col_val - Descending
</option>

HTML;
    }
    $result = <<<HTML
<div class="header">
    <span class="app-name">
        🅱️roduct Mana🅱️er
    </span>
    <span class="header-buttons">
        <select class="sorting-select">
            $options
        </select>
        <button class="create-button" onclick="create_button_click()">
            CREATE
        </button>
    </span>
</div>

HTML;

    return $result;
}

function skin_footer() {
    $result = <<<HTML
<div class="loader-image">
    <img class="loader-image-tag" src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif"></img>
</div>

HTML;

    return $result;
}

function skin_product_block($product) {
    $result = <<<HTML
<div class="product">
    <div class="product-corner">
        <div class="product-id">
            #$product[0]
        </div>
        <div class="product-corner-img product-delete">
            <img class="product-corner-img-tag product-delete-tag" src="resources/delete.png"></img>
        </div>
        <div class="product-corner-img product-edit">
            <img class="product-corner-img-tag product-edit-tag" src="resources/edit.png"></img>
        </div>
    </div>
    <div class="product-info">
        <div class="product-img">
            <img class="product-img-tag" src="$product[4]">
        </div>
        <div class="product-text">
            <div class="product-field product-name">
                <span class="field-name">
                    Name:
                </span>
                <input class="product-input" type="text" maxlength="100" name="name" value="$product[1]"></input>
                <span class="product-label">
                    $product[1]
                </span>
            </div>
            <div class="product-field product-price">
                <span class="field-name">
                    Price: 
                </span>
                <input class="product-input" type="text" name="price" maxlength="10" value="$product[3]"></input>
                <span>
                    $product[3] 
                </span>
            </div>
            <div class="product-field product-desc">
                <span class="field-name">
                    Description:
                </span>
                <textarea class="product-input" name="desc" maxlength="2000">$product[2]</textarea>
                <span>
                    $product[2]
                </span>
            </div>
        </div>
    </div>
</div>

HTML;

    return $result;
}

function skin_product_list($data) {
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
<div class="content">
    <a class="load_products invisible" href="/load_products.php?$request_params"></a>
    <div class="product-list">
        $list
    </div>
</div>
HTML;
    
    return $list_items;
}


?>
