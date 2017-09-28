<?php

//TODO: move to router.php
$GLOBALS['ROOT']=dirname(__FILE__, 2);

require_once($GLOBALS['ROOT'].'/src/controller.php'); 

$content = output_something();
?>

<!DOCTYPE html>
<html>
<body>
<?php echo $content;?>

</body>
</html> 
