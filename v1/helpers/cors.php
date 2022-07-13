<?php

    header("Access-Control-Allow-Origin: *");

    function get_base_url(){
        $type = "development";
        $port = $_SERVER["SERVER_PORT"];

        $base_url = sprintf(
            "%s://%s%s/",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'], ($port != "80" && $port != "443") ? ":$port" : ""
        );

        $append = ($type == "development") ? "" : "api/";
        $base_url .= $append;

        return $base_url;
    }
    
    $__BASE_URL__ = get_base_url();

?>