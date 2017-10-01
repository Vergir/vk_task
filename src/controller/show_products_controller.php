<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/view/show_products_view.php');

function show_products() {
    if (!init_data_access()) {
        return "Could not estabilish data access";
    }

    $params = array(
        'count' => 10,
        'start_from' => 0,
        'sort_by' => 'id',
        'ascending' => true);
    if (!empty($_REQUEST['params'])) {
        $request_params = explode('|', $_REQUEST['params']);
        $params['sort_by'] = $request_params[0];
        $params['ascending'] = $request_params[1];
    }

    $data = get_products($params);

    if (!$data) {
        return 'Error retrieveing products from Database';
    } else {
        $product_list = skin_product_list($data);
    }

    $header = skin_header($params);
    $footer = skin_footer();
    $create_product_modal = skin_create_modal();
    
    $page = $header.$product_list.$footer.$create_product_modal;

    return $page;
}       

?>
