<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/security.php');

function try_add_product() {
    if (!check_origin()) {
        return 'Product was NOT added - make sure your browser sets correct headers';
    }

    if (empty($_REQUEST['name'])
     || empty($_REQUEST['price'])) {
        return 'Product was NOT added - some required data missing';
    }
    
    if (!init_data_access()) {
        return 'Product was NOT added - Could not estabilish connection with database';
    }
    
    if (add_product($_REQUEST)) {
        return 'Product added successfully';
    } else {
        return 'Product was NOT added - Invalid product data (aka rejected by database)';
    }
}

?>
