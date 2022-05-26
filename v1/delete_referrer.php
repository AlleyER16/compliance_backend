<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    if(isset($_GET["ref_id"]) && $_GET["ref_id"] != ""){

        $ref_id = $_GET["ref_id"];

        require_once dirname(__FILE__, 2)."/ebl/Referrers.php";
        require_once dirname(__FILE__, 2)."/ebl/Employees.php";

        $ref_obj = new Referrers();
        $emp_object = new Employees();

        if($ref_obj->delete_referrer($__employee_details["ID"], $ref_id)){

            echo json_encode([
                "message" => "Deleted successfully",
                "referrers" => $ref_obj->get_referrers($__employee_details["ID"])
            ]);

        }else{

            echo json_encode([
                "message" => "Error deleting referrer"
            ]);

        }

    }else{

        echo json_encode([
            "message" => "Invalid input"
        ]);

    }

?>