<?php
require_once(__ROOT__.'/model/mysql.php');
require_once(__ROOT__.'/model/mc.php');

function init_data_access() {
    if (!init_mysql()) {
        $result = 'Failed init mysql';
        error_log($result);
        return false;
    }
    if (!init_mc()) {
        $result = 'Failed init memcached';
        error_log($result);
        return false;
    }
    return true;
}

function get_products($params) {
    $hash = md5(serialize($params));
    $result = array('params' => $params);

    $cache_result = cache_get($hash);
    if ($cache_result) {
        error_log('cache');
        $result['products'] = $cache_result;
        return $result;
    } else { 
        $sql_result = mysql_select($params['count'], $params['start_from'], $params['sort_by'], $params['ascending']);
        if ($sql_result) {
            cache_set($hash, $sql_result);
            $result['products'] = $sql_result;
            return $result;
        }
        return false;
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

?>
