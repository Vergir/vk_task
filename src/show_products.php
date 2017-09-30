<?php

define('__ROOT__', dirname('__FILE__', 2));

require_once(__ROOT__.'/controller/show_products_controller.php'); 

$content = show_products();
$js = file_get_contents('./javascript.html');

?>

<!DOCTYPE html>
<html>
    <?php echo $js?>
    <body>
        <?php echo $content;?>
    </body>
</html> 
