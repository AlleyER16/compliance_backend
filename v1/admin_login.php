<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    if(isset($_POST["username"]) && isset($_POST["password"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        if(!empty($username) && !empty($password)){

            if($username == "admin" && $password == "admin"){

                session_start();

                $_SESSION["admin_logged"] = "admin_logged";

                echo "Login successfully";

            }else{

                echo "Invalid credentials";

            }

        }else{

            echo "Fill in all fields";

        }

    }else{

        echo "All fields not set";

    }

?>