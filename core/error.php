<?php

function JSON($arr = array()) {
    return json_encode($arr);
};

function apiError($message) {
    echo JSON(array(
        'status' => 500,
        'message' => $message
    )); exit;
};

?>