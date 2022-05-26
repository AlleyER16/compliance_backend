<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    if(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["gender"]) 
    && isset($_POST["username"]) && isset($_POST["password"])){

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $gender = $_POST["gender"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($username) && !empty($password)){

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();

            if($emp_object->username_exists($username)){
                
                echo json_encode([
                    "message" => "Username has been used"
                ]);
                die();
            }

            $add_employee = $emp_object->add_employee($first_name, $last_name, $gender, $username, md5($password));

            if($add_employee[0]){

                $employee_id = $add_employee[1];

                session_start();

                $_SESSION["employee_logged"] = $employee_id;

                echo json_encode([
                    "message" => "Employee added successfully",
                    "user_info" => $emp_object->get_employee($employee_id)[1],
                    "user_referrers" => []
                ]);
            
            }else{

                echo json_encode([
                    "message" => "Error adding employee. Try again"
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