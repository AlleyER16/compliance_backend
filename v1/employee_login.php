<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    if(isset($_POST["username"]) && isset($_POST["password"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        if(!empty($username) && !empty($password)){

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();

            $employee_login = $emp_object->employee_login($username, md5($password));

            if($employee_login[0]){

                session_start();

                $_SESSION["employee_logged"] = $employee_login[1]["ID"];

                require_once dirname(__FILE__, 2)."/ebl/Referrers.php";

                $ref_object = new Referrers();

                $employee_info = $employee_login[1];

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
                    "message" => "Login successfully",
                    "user_info" => $employee_info,
                    "user_referrers" => $ref_object->get_referrers($employee_login[1]["ID"])
                ]);

            }else{

                echo json_encode([
                    "message" => "Invalid credentials"
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