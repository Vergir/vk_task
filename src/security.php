<?php

function check_origin() {
    $origin = '';
    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        $origin = explode('/', $_SERVER['HTTP_ORIGIN'])[2];
    } else if (!empty($_SERVER['HTTP_REFERER'])) {
        $origin = explode('/', $_SERVER['HTTP_REFERER'])[2];
    }

    $result = ($origin === '139.162.148.240:8000');

    return $result;
}


?>
