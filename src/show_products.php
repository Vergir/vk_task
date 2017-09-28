<?php

define('__ROOT__', dirname(__FILE__, 2));
require_once(__ROOT__.'/src/mysql.php'); 

if (!init_mysql()) {
    $result = 'Failed';
} else {
    if (($result = select_products(100)) == false) {
        $result = 'Select Failed';
    } else {
        $result = mysqli_num_rows($result);
    }
}
?>

<!DOCTYPE html>
<html>
<body>
<?php echo $result; ?>

</body>
</html> 
