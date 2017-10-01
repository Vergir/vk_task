<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/view/show_products_view.php');
define('LINK_DELIMITER', '|');

function construct_response($data) {
    $div_blocks = '';
    foreach ($data['products'] as $item)
        $div_blocks .= skin_product_block($item);
    
    $params = $data['params'];
    $new_load_link = "load_products.php?".
                "&sort=$params[sort_by]".
                "&count=$params[count]".
                "&start_from=$params[start_from]".
                "&asc=$params[ascending]";

    return $new_load_link.LINK_DELIMITER.$div_blocks;
}

function load_products() {
    //TODO: More validation/sanitization
    
    if (!init_data_access()) {
        return false;
    }

    $new_start_pos = intval($_REQUEST['start_from']) + intval($_REQUEST['count']);
    $params = array(
        'count' => $_REQUEST['count'],
        'start_from' => $new_start_pos,
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
