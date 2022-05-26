<?php

    session_start();

    if(!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] != "admin_logged"){
        // http_response_code(401);die();
    }

?>