<?php

define('DEF_EXP_TIME', 600);

$mc = NULL;

function init_mc() {
    global $mc;

    $config = parse_ini_file(__ROOT__.'/../config/mc.ini');
    $mc = memcache_pconnect($config['host'], $config['port']);
    if (!$mc) {
        error_log("Memcached init failed");
        return false;
    }
    
    return true;
}

function cache_get($key) {
    global $mc;

    return memcache_get($mc, $key);
}

function cache_set($key, $value) {
    global $mc;
    
    return memcache_set($mc, $key, $value, 0, DEF_EXP_TIME);
}

function cache_flush() {
    global $mc;
    
    memcache_flush($mc);
}

?>
