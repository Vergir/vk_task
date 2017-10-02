<?php 
define('__ROOT__', dirname('__FILE__', 2));
require_once(__ROOT__.'/controller/delete_product_controller.php');

$result = try_delete_product();

echo $result;
?>
