<?php
require_once(__ROOT__.'/model/data_access.php');

function try_update_product() {
    //TODO: better validation / sanitization
    if (empty($_REQUEST['old_id'])
     || empty($_REQUEST['name'])
     || empty($_REQUEST['img'])
     || empty($_REQUEST['desc'])
     || empty($_REQUEST['price'])) {
        return "Product was NOT changed - some data missing";
    }
    
    if (!init_data_access()) {
        return "Product was NOT changed - Could not estabilish connection with database";
    }
    
    if (update_product($_REQUEST)) {
        return "success";
    } else {
        return "Product was NOT changed - Rejected by database";
    }
}

?>
