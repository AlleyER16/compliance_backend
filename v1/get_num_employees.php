<?php

    require_once dirname(__FILE__) . "/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__) . "/includes/admin_logged.php";

    require_once dirname(__FILE__, 2) . "/ebl/Employees.php";

    $emp_object = new Employees();

    echo $emp_object->get_total_employees();

?>