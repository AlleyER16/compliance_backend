<?php

    session_start();

    //Would not work cause the react app is on separate url and sessions are not cross URL's
    //Uncomment on production
    if(!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] != "admin_logged"){
        // http_response_code(401);die();
    }

?>