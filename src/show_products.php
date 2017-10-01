<?php

define('__ROOT__', dirname('__FILE__', 2));

require_once(__ROOT__.'/controller/show_products_controller.php'); 

$content = show_products();
$css_js = file_get_contents('./css_js.html');

?>

<!DOCTYPE html>
<html>
<?php echo $css_js;?>
<body>
<?php echo $content;?>
</body>
</html> 
