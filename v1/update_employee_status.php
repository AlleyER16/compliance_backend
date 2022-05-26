<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    require_once dirname(__FILE__)."/includes/admin_logged.php";

    if(isset($_POST["emp_id"]) && isset($_POST["status"])){

        $emp_id = $_POST["emp_id"];
        $status = $_POST["status"];

        if($emp_id != "" && $status != ""){

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();

            if($emp_object->update_employee_datum($emp_id, "Status", $status)){

                echo "Employee status updated successfully";

            }else{

                echo "Error updating employee status";

            }

        }else{

            echo "Fill in all fields";

        }

    }else{

        echo "All fields not set";

    }

?>