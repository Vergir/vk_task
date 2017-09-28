<?php


require_once($GLOBALS['ROOT'].'/src/mysql.php');
require_once($GLOBALS['ROOT'].'/src/memcached.php');

function init_data_access() {
    if (!init_mysql()) {
        $result = 'Failed init mysql';
        error_log($result);
        return false;
    }
    if (!init_memcached()) {
        $result = 'Failed init memcached';
        error_log($result);
        return true;
    }
    return true;
}

function output_something($arg1=40) {
    if (!init_data_access()) {
        return "Could not estabilish data access";
    }

    $products = select_products($arg1);

    while ($item = mysqli_fetch_array($products)) {
        $result .= "<li> $item[id] $item[name] $item[price] </li>";
    }

    return $result;
}       

?>
