<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    header("Content-Type: application/json");

    require_once dirname(__FILE__)."/includes/admin_logged.php";

    $status = $_GET["status"] ?? 1;
    $search_keyword = $_GET["search"] ?? "";
    $page = $_GET["page"] ?? 1;
    $division = $_GET["division"] ?? 4;

    require_once dirname(__FILE__, 2)."/ebl/Employees.php";
    require_once dirname(__FILE__, 2)."/ebl/Referrers.php";

    $emp_object = new Employees();
    $ref_object = new Referrers();

    $employees = $emp_object->get_employees($search_keyword, $status, $page, $division);

    for($i = 0; $i < count($employees); $i++){

        if($employees[$i]["Picture"] != NULL){

            $employees[$i]["Picture"] = $__BASE_URL__."dc/".$employees[$i]["Picture"];

        }

        if($employees[$i]["IDCard"] != NULL){

            $employees[$i]["IDCard"] = $__BASE_URL__."dc/".$employees[$i]["IDCard"];

        }

        if($employees[$i]["ProofOfAddress"] != NULL){

            $employees[$i]["ProofOfAddress"] = $__BASE_URL__."dc/".$employees[$i]["ProofOfAddress"];

        }

        $employees[$i]["referrers"] = $ref_object->get_referrers($employees[$i]["ID"]);

    }

    echo json_encode([
        "message" => "Employees fetched successfully",
        "meta_data" => [
            "num_records" => $emp_object->get_num_employees($search_keyword, $status),
            "pagination" => $emp_object->get_employees_pagination($search_keyword, $status, $division),
            "page" => (int) $page,
            "division" => $division
        ],
        "employees" => $employees
    ]);

?>