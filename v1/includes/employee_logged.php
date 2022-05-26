<?php

    session_start();

    // if(!isset($_SESSION["employee_logged"]) || $_SESSION["employee_logged"] == ""){
    //     http_response_code(401);die();
    // }

    $employee_id = $_SESSION["employee_logged"] ?? 1;
    
    require_once dirname(__FILE__, 3)."/ebl/Employees.php";

    $emp_object = new Employees();

    $employee = $emp_object->get_employee($employee_id);

    if(!$employee[0]){
        http_response_code(401);die();
    }


    $__employee_details = $employee[1];

?>