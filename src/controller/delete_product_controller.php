<?php
require_once(__ROOT__.'/model/data_access.php');

function try_delete_product() {
    if (empty($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
        return "error|Product was NOT removed - Invalid ID";
    }
    
    if (!init_data_access()) {
        return "error|Product was NOT removed - Could not estabilish connection with database";
    }
    
    if (delete_product($_REQUEST)) {
        return "success|Product removed successfully";
    } else {
        return "error|Product was NOT removed - rejected by database";
    }
}

?>
