<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/employee_logged.php";

    if(isset($_POST["document"]) && isset($_FILES["file"])){

        $document = $_POST["document"];
        $file = $_FILES["file"];

        if(!empty($document) && !empty($file)){

            require_once dirname(__FILE__, 2)."/ebl/Employees.php";

            $emp_object = new Employees();

            $root_dir = "../dc/".$__employee_details["ID"]."/";

            if(!file_exists($root_dir)){

                mkdir($root_dir);

            }

            $new_file_name = uniqid()."_".$file["name"];

            $destination = $root_dir.$new_file_name;

            if(move_uploaded_file($file["tmp_name"], $destination)){

                $update = $__employee_details["ID"]."/$new_file_name";

                if($emp_object->update_employee_datum($__employee_details["ID"], $document, $update)){
                            
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
                        "message" => "Updated successfully",
                        "user_info" => $employee_info
                    ]);

                }else{

                    echo json_encode([
                        "message" => "Error updating document. Try again"
                    ]);

                }

            }else{

                echo json_encode([
                    "message" => "Error uploading document. Try again"
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