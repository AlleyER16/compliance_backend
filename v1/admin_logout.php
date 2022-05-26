<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    require_once dirname(__FILE__)."/includes/admin_logged.php";

    unset($_SESSION["admin_logged"]);

    echo "Logged out successfully";

?>