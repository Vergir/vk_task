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

    $data = get_products($params);

    if (!$data) {
        $result = 'LMAO KEK';
    } else {
        $result = skin_product_list($data);
    }

    return $result;
}       

?>
