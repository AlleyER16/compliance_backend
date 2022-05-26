<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    unset($_SESSION["employee_logged"]);

    echo "Logged out successfully";

?>