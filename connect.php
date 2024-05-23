<?php

$connection = oci_connect("cfx_12", "cfxadmin#22", "//localhost/xe");

if (!$connection) {
    $error_message = oci_error();
    echo "Failed to connect to Oracle: " . $error_message['message'];
    exit();
}


?>