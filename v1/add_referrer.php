<?php   

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    if(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email_address"]) && isset($_POST["telephone_number"])){

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email_address = $_POST["email_address"];
        $telephone_number = $_POST["telephone_number"];

        if(!empty($first_name) && !empty($last_name) && !empty($email_address) && !empty($telephone_number)){

            require_once dirname(__FILE__, 2)."/ebl/Referrers.php";

            $ref_obj = new Referrers();

            if($ref_obj->referrer_exists($__employee_details["ID"], "TelephoneNumber", $telephone_number)){
                echo json_encode(["message" => "You've already added a referral with telephone number:$telephone_number"]);
                die();
            }

            if($ref_obj->referrer_exists($__employee_details["ID"], "EmailAddress", $email_address)){
                echo json_encode(["message" => "You've already added a referral with email:$email_address"]);
                die();
            }

            if($ref_obj->add_referrer($__employee_details["ID"], $first_name, $last_name, $telephone_number, $email_address)){

                echo json_encode([
                    "message" => "Referrer added successfully",
                    "referrers" => $ref_obj->get_referrers($__employee_details["ID"])
                ]);

            }else{

                echo json_encode(["message" => "Error adding referrer. Try again"]);

            }

        }else{

            echo json_encode(["message" => "Fill in all fields"]);

        }

    }else{

        echo json_encode(["message" => "All fields not set"]);

    }

?>