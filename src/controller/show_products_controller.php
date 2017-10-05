<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/view/show_products_view.php');
require_once(__ROOT__.'/security.php');

function receive_params() {
    $result = array(
        'count' => 10,
        'start_from' => 0,
        'sort_by' => 'id',
        'ascending' => true);

    if (!empty($_REQUEST['params'])) {
        $request_params = explode('|', $_REQUEST['params']);
        $result['sort_by'] = $request_params[0];
        $result['ascending'] = $request_params[1];
    }

    return $result;
}

function show_products() {
    if (!init_data_access()) {
        return "Could not estabilish data access";
    }

    $params = receive_params();

    $data = get_products($params);

    if (!$data) {
        return 'Error retrieving products from Database';
    }

    $header               = skin_header($params);
    $product_list         = skin_product_list($data);
    $footer               = skin_footer();
    $create_product_modal = skin_create_modal();
    
    $page = $header.$product_list.$footer.$create_product_modal;

    return $page;
}       

?>
