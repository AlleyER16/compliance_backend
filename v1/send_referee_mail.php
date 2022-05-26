<?php

    require_once dirname(__FILE__)."/helpers/cors.php";

    require_once dirname(__FILE__)."/includes/admin_logged.php";

    if(!isset($_GET["ref_id"]) || $_GET["ref_id"] == ""){
        die("Error sending mail. Try again");
    }

    $ref_id = $_GET["ref_id"];

    require_once dirname(__FILE__, 2)."/ebl/Referrers.php";

    $ref_obj = new Referrers();

    $referrer = $ref_obj->get_referrer($ref_id);

    if(!$referrer[0]){
        die("Error identifying referrer");
    }

    $referrer_details = $referrer[1];

    require_once dirname(__FILE__, 2)."/ebl/Employees.php";

    $emp_object = new Employees();

    $employee_details = $emp_object->get_employee($referrer_details["Employee"])[1];

    $message    = 'Reply this email to confirm an Employee in our portal\n\nEmployee Name: '.$employee_details["FirstName"]." ".$employee_details["LastName"];

    if(@mail($referrer_details["EmailAddress"], "Confirm Employee", $message)){

        echo 'Referee has being emailed successfully';

    }else{

        echo "Error sending email";

    }

?>