<?php

const COLUMNS = array ( 'id', 'name', 'desc', 'price', 'img');

$mysqli = NULL;

function init_mysql() {
    global $mysqli;

    $db = parse_ini_file(__ROOT__.'/../config/mysql.ini');

    $mysqli = mysqli_connect('p:'.$db['host'], $db['user'], $db['pwd'], $db['dbname'], $db['port']);
    if (!$mysqli) {
            error_log('mysqli_connect failed (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
            return false;
    }

    return true;
}

function mysql_select($count = 1000, $start_from = 0, $sort_by = 'id', $ascending = true) {
    global $mysqli;

    $count      = mysqli_real_escape_string($mysqli, $count);
    $start_from = mysqli_real_escape_string($mysqli, $start_from);
    $sort_by    = mysqli_real_escape_string($mysqli, $sort_by);
    $ascending  = mysqli_real_escape_string($mysqli, $ascending);

    $asc_desc = $ascending ? 'ASC' : 'DESC';

    $query = <<<SQL
SELECT * 
FROM products
ORDER BY $sort_by $asc_desc
LIMIT $start_from,$count
SQL;

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return mysqli_fetch_all($result);
}

function mysql_insert($name, $desc, $price, $img) {
    global $mysqli;


    $name  = mysqli_real_escape_string($mysqli, $name);
    $desc  = mysqli_real_escape_string($mysqli, $desc);
    $price = mysqli_real_escape_string($mysqli, $price);
    $img   = mysqli_real_escape_string($mysqli, $img);

    $query = <<<SQL
INSERT
INTO products(`name`, `desc`, `price`, `img`)
VALUES ('$name', '$desc', $price, '$img')
SQL;

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}

function mysql_update($old_id, $name, $desc, $price, $img) {
    global $mysqli;

    $old_id = mysqli_real_escape_string($mysqli, $old_id);
    $name   = mysqli_real_escape_string($mysqli, $name);
    $desc   = mysqli_real_escape_string($mysqli, $desc);
    $price  = mysqli_real_escape_string($mysqli, $price);
    $img    = mysqli_real_escape_string($mysqli, $img);

    $query  = <<<SQL
UPDATE products
SET `name`='$name',`desc`='$desc',`price`=$price,`img`='$img'
WHERE id=$old_id
SQL;

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}

function mysql_delete($id) {
    global $mysqli;

    $id = mysqli_real_escape_string($mysqli, $id);

    $query = <<<SQL
DELETE
FROM products
WHERE id=$id
SQL;

    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        error_log(mysqli_error($mysqli));
    }
    
    return $result;
}
?>
