<?php

require_once 'db.php';
require_once 'commonFunctions.php';

$retun_data = Array(
    "status" => 0,
    "message" => "",
    "data" => array()
);

if ($_POST['requestType'] == "insert") {

    $jsonFile = '../json_data/code_challenge_events.json';
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData);

    if (!empty($data)) {
        $data_insert_status = 0;  //0=> failed, 1=> insert, 2=> alraedy 
        foreach ($data as $index => $obj) {

            $employee_id = "";
            $event_id = "";
            $participation_id = "";

            $emmployee_data = getEmployeeInfo($obj->employee_name, $obj->employee_mail);

            if (!$emmployee_data) {

                $employee_data = array(
                    "employee_name" => $obj->employee_name,
                    "employee_mail" => $obj->employee_mail,
                );

                $employee_id = insertEmployeeData($employee_data);
            } else {

                $employee_id = $emmployee_data['employee_id'];
            }

            $event_data = getEventInfo($obj->event_name);
            if (!$event_data) {
                $event_data = array(
                    "event_name" => $obj->event_name,
                    "event_date" => date('Y-m-d', strtotime($obj->event_date))
                );

                $event_id = insertEventData($event_data);
            } else {
                $event_id = $event_data['event_id'];
            }

            if ($event_id and $employee_id) {
                $perticipante_data = getParticipationInfo($event_id, $employee_id);

                if (!$perticipante_data) {
                    $participation_data = array(
                        "event_id" => $event_id,
                        "employee_id" => $employee_id,
                        "participation_fee" => $obj->participation_fee,
                    );

                    $participation_id = insertParticipationData($participation_data);

                    if ($participation_id) {
                        $data_insert_status = 1;
                    }
                } else {
                    $data_insert_status = 2;
                }
            }
        }

        if ($data_insert_status == "1") {
            $retun_data['message'] = "Success";
            $retun_data['status'] = 1;

            $retun_data['data'] = getAllParticipationInformation();
        } else if ($data_insert_status == "2") {
            $retun_data['message'] = "No new data was found to insert";
            $retun_data['status'] = 2;
        } else {
            $retun_data['message'] = "Data insert failed! Please try again";
        }
    } else {
        $retun_data['message'] = "Something is wrong! Please try again";
    }
}


if ($_POST['requestType'] == "delete") {

    deleteParticipationAllData();
    deleteEventAllData();
    deleteEmployeeAllData();

    $retun_data['message'] = "Successfully delete ";
    $retun_data['status'] = 1;
}

echo json_encode($retun_data);
?>