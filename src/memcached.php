<?php

define('DEF_EXP_TIME', 600);

$memcached = NULL;

function init_memcached() {
    global $memcached;

    $memcached = new Memcached('unique');
    if (!$memcached) {
        error_log("Memcached init failed: $memcached->getResultCode");
        return false;
    }
    
    if (count($memcached->getServerList()) === 0) {
        $mc = parse_ini_file($GLOBALS['ROOT'].'/config/memcached.ini');
        $memcached->addServer($mc['host'],$mc['port']);
    }
    return true;
}

function cache_get($key) {
    global $memcached;

    return $memcached->get($key);
}

function cache_set($key, $value) {
    global $memcached;
    
    return $memcached->set($key, $value, DEF_EXP_TIME);
}

function cache_flush() {
    global $memcached;
    
    $memcached->flush();
}

?>
