<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/view/show_products_view.php');
define('LINK_DELIMITER', '|');

function construct_response($data) {
    $div_blocks = '';
    foreach ($data['products'] as $item)
        $div_blocks .= skin_product_block($item);
    
    $params = $data['params'];
    $new_counter = intval($params['start_from']) + intval($params['count']);
    $new_load_link = "load_products.php?".
                "&sort=$params[sort_by]".
                "&count=$params[count]".
                "&start_from=$new_counter".
                "&asc=$params[ascending]";

    return $new_load_link.LINK_DELIMITER.$div_blocks;
}

function load_products() {
    //TODO: More validation/sanitization
    
    if (!init_data_access()) {
        return false;
    }

    $params = array(
        'count' => $_REQUEST['count'],
        'start_from' => $_REQUEST['start_from'],
        'sort_by' => $_REQUEST['sort'],
        'ascending' => $_REQUEST['asc']);

    $data = get_products($params);
    
    if (!$data) {
        $result = false;
    } else {
        $result = construct_response($data);
    }
    
    return $result;

}
?>
