<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    if(isset($_POST["username"]) && !empty($_POST["username"])){

        $username = $_POST["username"];

        require_once dirname(__FILE__, 2)."/ebl/Employees.php";

        $emp_object = new Employees();

        if($username != $__employee_details["Username"] && $emp_object->exployee_exists_uc("Username", $username)){
            echo json_encode([
                "message" => "Username has been used"
            ]);
            die();
        }

        if($emp_object->update_employee_datum($__employee_details["ID"], "Username", $username)){

            $employee_info = $emp_object->get_employee($__employee_details["ID"])[1];

            if($employee_info["Picture"] != NULL){

                $employee_info["Picture"] = $__BASE_URL__."dc/".$employee_info["Picture"];
    
            }

            if($employee_info["IDCard"] != NULL){

                $employee_info["IDCard"] = $__BASE_URL__."dc/".$employee_info["IDCard"];
    
            }
    
            if($employee_info["ProofOfAddress"] != NULL){
    
                $employee_info["ProofOfAddress"] = $__BASE_URL__."dc/".$employee_info["ProofOfAddress"];
    
            }

            echo json_encode([
                "message" => "Username updated successfully",
                "user_info" => $employee_info
            ]); 

        }else{

            echo json_encode([
                "message" => "Error changing username. Try again"
            ]); 

        }

    }else{

        echo json_encode([
            "message" => "Username is required"
        ]);

    }

?>