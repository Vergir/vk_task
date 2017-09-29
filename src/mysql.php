<?php

const COLUMNS = array ( 'id', 'name', 'desc', 'price', 'img');

$mysqli = NULL;

function init_mysql() {
    global $mysqli;

    $db = parse_ini_file($GLOBALS['ROOT'].'/config/mysql.ini');

    $mysqli = mysqli_connect('p:'.$db['host'], $db['user'], $db['pwd'], $db['dbname'], $db['port']);
    if (!$mysqli) {
            error_log('mysqli_connect failed (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
            return false;
    }

    return true;
}

function mysql_select($count = 1000, $start_from = 0, $sort_by = 'id', $ascending = true) {
    global $mysqli;

    if (!in_array($sort_by, COLUMNS) 
     || !is_numeric($start_from)
     || !is_numeric($count) 
     || !($start_from >= 0)
     || !($count > 0)) {
        return false;
    }
    $asc_desc = $ascending ? 'ASC' : 'DESC';

    $query = 'SELECT * '. 
             'FROM products '.
             "ORDER BY $sort_by $asc_desc ".
             "LIMIT $start_from,$count";

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return mysqli_fetch_all($result);
}

function mysql_insert($name, $desc, $price, $img) {
    global $mysqli;

    if (empty($name)
     || empty($desc)
     || empty($price)
     || empty($img)
     || price < 0) {
        return false;
    }

    $query = 'INSERT '.
             'INTO products(id, name, desc, price, img) '.
             "VALUES ($name, $desc, $price, $img)";

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}

function mysql_update($old_id, $name, $desc, $price, $img) {
    global $mysqli;

    if (empty($old_id)
     || empty($name)
     || empty($desc)
     || empty($price)
     || empty($img)
     || price < 0) {
        return false;
    }

    $query = 'UPDATE products'.
             "SET name=$name, desc=$desc, price=$price, img=$img ".
             "WHERE id=$old_id";

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}

function mysql_delete($id) {
    global $mysqli;

    if (empty($id))  {
        return false;
    }

    $query = 'DELETE '.
             'FROM products '.
             "WHERE id=$id";

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}
?>
