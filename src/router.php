<?php

$GLOBALS['ROOT']=dirname(__FILE__, 2);

if ($_SERVER['REQUEST_URI'] === '/show_products.php') {
    return false;
}
else {
    header('Location: /show_products.php');
}

?>
