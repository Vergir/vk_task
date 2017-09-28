<?php

define('__ROOT__', dirname(__FILE__, 2));

require_once(__ROOT__.'/src/mysql.php'); 
require_once(__ROOT__.'/src/memcached.php'); 

if (!init_mysql()) {
    $result = 'Failed init mysql';
    error_log($result);
    die(1);
} 
if (!init_memcached()) {
    $result = 'Failed init memcached';
    error_log($result);
    die(1);
}

$products = select_products(40);
$result = '';

while ($item = mysqli_fetch_array($products)) {
    $result .= "<li> $item[id] $item[name] $item[price] </li>";
}
?>

<!DOCTYPE html>
<html>
<body>
<?php echo $result; ?>

</body>
</html> 
