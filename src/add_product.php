<?php 
define('__ROOT__', dirname('__FILE__', 2));
require_once(__ROOT__.'/controller/add_product_controller.php');

$result = try_add_product();

echo $result;
?>
