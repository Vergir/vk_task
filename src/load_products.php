<?php 
define('__ROOT__', dirname('__FILE__', 2));
require_once(__ROOT__.'/controller/load_products_controller.php');

$content = load_products();

echo $content;
?>
