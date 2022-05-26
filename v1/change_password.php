<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";             

    if(isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])){

        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if(!empty($current_password) && !empty($new_password) && !empty($confirm_password)){

            if(md5($current_password) != $__employee_details["Password"]){

                echo json_encode([
                    "message" => "Invalid current password"
                ]);
                die();

            }

            if($new_password != $confirm_password){

                echo json_encode([
                    "message" => "Passwords do not match"
                ]);
                die();

            }

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();           
            
            if($emp_object->update_employee_datum($__employee_details["ID"], "Password", md5($confirm_password))){

                echo json_encode([
                    "message" => "Password updated successfully"
                ]);

            }else{

                echo json_encode([
                    "message" => "Error updating password. Try again"
                ]);

            }

        }else{

            echo json_encode([
                "message" => "Fill in all fields"
            ]);

        }

    }else{

        echo json_encode([
            "message" => "All fields not set"
        ]);

    }

?>