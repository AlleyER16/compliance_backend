<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    if(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["gender"]) && isset($_POST["address"])
    && isset($_POST["town_or_city"]) && isset($_POST["email_address"]) && isset($_POST["telephone_number"]) 
    && isset($_POST["national_insurance"]) && isset($_POST["sia_license"]) && isset($_POST["pin"])
    && isset($_POST["immigration_status"]) && isset($_POST["bank_sort_code"]) && isset($_POST["account_number"])
    && isset($_POST["account_name"])){

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $town_or_city = $_POST["town_or_city"];
        $email_address = $_POST["email_address"];
        $telephone_number = $_POST["telephone_number"];
        $national_insurance = $_POST["national_insurance"];
        $sia_license = $_POST["sia_license"];
        $pin = $_POST["pin"];
        $immigration_status = $_POST["immigration_status"];
        $bank_sort_code = $_POST["bank_sort_code"];
        $account_number = $_POST["account_number"];
        $account_name = $_POST["account_name"];

        if(!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($address) && !empty($town_or_city) 
        && !empty($email_address) && !empty($telephone_number) && !empty($sia_license) && !empty($immigration_status) 
        && !empty($bank_sort_code) && !empty($account_number)){

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();

            if($telephone_number != $__employee_details["TelephoneNumber"] && $emp_object->exployee_exists_uc("TelephoneNumber", $telephone_number)){
                echo json_encode([
                    "message" => "Telephone number has been used"
                ]);
                die();
            }

            if($email_address != $__employee_details["EmailAddress"] && $emp_object->exployee_exists_uc("EmailAddress", $email_address)){
                echo json_encode([
                    "message" => "Email address has been used"
                ]);
                die();
            }

            if($emp_object->update_employee_info($first_name, $last_name, $gender, $address, $town_or_city, $email_address, $telephone_number, $national_insurance, $sia_license, $pin, $immigration_status, $bank_sort_code, $account_number, $account_name, $__employee_details["ID"])){

                if(isset($_FILES["picture"]) && !empty($_FILES["picture"])){

                    $picture = $_FILES["picture"];

                    $root_dir = "../dc/".$__employee_details["ID"]."/";

                    if(!file_exists($root_dir)){

                        mkdir($root_dir);

                    }

                    $new_file_name = uniqid()."_".$picture["name"];

                    $destination = $root_dir.$new_file_name;

                    if(move_uploaded_file($picture["tmp_name"], $destination)){

                        $update = $__employee_details["ID"]."/$new_file_name";

                        if($emp_object->update_employee_datum($__employee_details["ID"], "Picture", $update)){
                            
                            //done

                        }else{

                            echo json_encode([
                                "message" => "Error updating picture. Try again"
                            ]);
                            die();

                        }

                    }else{

                        echo json_encode([
                            "message" => "Error uploading picture. Try again"
                        ]);
                        die();

                    }

                }

                $employee_info = $emp_object->get_employee($__employee_details["ID"])[1];
                $employee_info["Picture"] = $__BASE_URL__."dc/".$employee_info["Picture"];

                if($employee_info["IDCard"] != NULL){

                    $employee_info["IDCard"] = $__BASE_URL__."dc/".$employee_info["IDCard"];
        
                }
        
                if($employee_info["ProofOfAddress"] != NULL){
        
                    $employee_info["ProofOfAddress"] = $__BASE_URL__."dc/".$employee_info["ProofOfAddress"];
        
                }

                echo json_encode([
                    "message" => "Updated successfully",
                    "user_info" => $employee_info
                ]);

            }else{

                echo json_encode([
                    "message" => "Error updating info. Try again"
                ]);

            }

        }else{

            echo json_encode([
                "message" => "Fill in all required fields"
            ]);

        }

    }else{

        echo json_encode([
            "message" => "All fields not set"
        ]);

    }

?>