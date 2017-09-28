<?php

define('DEF_EXP_TIME', 600);

$memcached = NULL;

function init_memcached() {
    global $memcached;

    $memcached = new Memcached();
    $memcached->addServer('127.0.0.1', 11211);
    if (!$memcached) {
        error_log("Memcached init failed: $memcached->getResultCode");
        return false;
    }
    
    return true;
}

function cache_get($key) {
    global $memcached;

    return $memcached.get($key);
}

function cache_set($key, $value) {
    global $memcached;
    
    return $memcached.set($key, $value, DEF_EXP_TIME);
}

?>
