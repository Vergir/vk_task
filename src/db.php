<?php

$mysqli = NULL;
$prep_queries = array();

function init_mysql() {
    global $mysqli;

    $db = parse_ini_file(__ROOT__.'/config/db.ini');

    $mysqli = mysqli_init();
    if (!$mysqli) {
            error_log('mysql_init failed');
            return false;
    }

    if (!mysqli_real_connect($mysqli, $db['host'], $db['user'], $db['pwd'], $db['dbname'], $db['port'])) {
            error_log('real_connect error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
            return false;
    }

    return true;
}

function select_products($count = 1000, $start_from = 0, $sort_by = "id", $ascending = true) {
}

?>
