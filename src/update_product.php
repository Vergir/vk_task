<?php 
define('__ROOT__', dirname('__FILE__', 2));
require_once(__ROOT__.'/controller/update_product_controller.php');

$result = try_update_product();

echo $result;
?>
