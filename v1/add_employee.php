<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    require_once dirname(__FILE__)."/includes/admin_logged.php";

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

                die("Username has been used");
            
            }

            if($emp_object->add_employee($first_name, $last_name, $gender, $username, md5($password))[0]){

                echo "Employee added successfully";
            
            }else{
            
                echo "Error adding employee. Try again";
            
            }

        }else{

            echo "Fill in all fields";

        }

    }else{

        echo "All fields not set";

    }

?>