<?php
require_once(__ROOT__.'/model/data_access.php');

function try_add_product() {
    //TODO: better validation / sanitization
    if (empty($_REQUEST['name'])
     || empty($_REQUEST['img'])
     || empty($_REQUEST['desc'])
     || empty($_REQUEST['price'])) {
        return "Product was NOT added - some data left blank";
    }
    
    if (!init_data_access()) {
        return "Product was NOT added - Could not estabilish connection with database";
    }
    
    if (add_product($_REQUEST)) {
        return "Product added successfully";
    } else {
        return "Product was NOT added - Invalid product data";
    }
}

?>
