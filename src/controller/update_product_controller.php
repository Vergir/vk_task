<?php
require_once(__ROOT__.'/model/data_access.php');
require_once(__ROOT__.'/security.php');

function try_update_product() {
    if (!check_origin()) {
        return 'Product was NOT changed - make sure your browser sets headers correctly';
    }

    if (empty($_REQUEST['old_id'])
     || empty($_REQUEST['name'])
     || empty($_REQUEST['price'])) {
        return 'Product was NOT changed - some required data missing';
    }
    
    if (!init_data_access()) {
        return 'Product was NOT changed - Could not estabilish connection with database';
    }
    
    if (update_product($_REQUEST)) {
        return 'success';
    } else {
        return 'Product was NOT changed - invalid product data (aka rejected by database)';
    }
}

?>
