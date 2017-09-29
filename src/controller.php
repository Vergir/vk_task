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

function get_products($params) {
    $hash = md5(serialize($params));

    $cache_result = cache_get($hash);
    if ($cache_result) {
        return $cache_result;
    } else { 
        $sql_result = mysql_select($params['count'], $params['start_from'], $params['sort_by'], $params['ascending']);
        if ($sql_result) {
            cache_set($hash, $sql_result);
        }
        return $sql_result;
    }
}

function add_product($params) {
    $query_result = mysql_insert($params['name'], $params['desc'], $params['price'], $params['img']);
    if ($query_result) {
        cache_flush();
    }

    return $query_result;
}

function update_product($params) {
    $query_result = mysql_update($params['old_id'], $params['name'], $params['desc'], $params['price'], $params['img']);
    if ($query_result) {
        cache_flush();
    }

    return $query_result;
}

function delete_product($params) {
    $query_result = mysql_delete($params['id']);
    if ($query_result) {
        cache_flush();
    }

    return $query_result;
}

function output_something($arg1=40) {
    if (!init_data_access()) {
        return "Could not estabilish data access";
    }

    $params = array(
        'count' => 100,
        'start_from' => 0,
        'sort_by' => 'id',
        'ascending' => true);

    $result = '';

    $products = get_products($params);

    if (!$products) {
        $result = 'LMAO KEK';
    } else {
        foreach ($products as $item) {
            $result .= "<li> $item[0] $item[1] $item[3] </li>";
        }
    }

    return $result;
}       

?>
