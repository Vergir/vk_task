<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/src/db.php'); 

if (!init_mysql()) {
    $result = 'Failed';
} else {
    $result = $mysqli->host_info;
}
?>

<!DOCTYPE html>
<html>
<body>
<?php echo $result; ?>

</body>
</html> 
