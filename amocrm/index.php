<?php
require_once(__DIR__ . "/amo.controller.php");

function onSendForm($formID, $result) {

    $data = [
        "pipeline_id" => 4579693,
        "status_id" => 42160492
    ];

    $amo = new amoCrmController();
    if($formID == 53) {
        $data["name"] = "Онлайн заявка";
        $user = $amo->searchUser([ "name" => $result['client_name'], "phone" => $result['client_tel'], "email" => "" ]);
    } elseif($formID == 3460) {
        $data["name"] = "Обратный звонок";
        $user = $amo->searchUser([ "name" => $result['client_name'], "phone" => $result['client_tel'], "email" => "" ]);
    } elseif($formID == 3132) {
        $data["name"] = "Истра {$result['vozrast']} лет";
        $user = $amo->searchUser([ "name" => $result['fio'], "phone" => $result['tel'], "email" => $result['email'] ]);
    }

    $lead = $amo->createLead($data);

    if(
        isset($lead->_embedded) &&
        isset($lead->_embedded->leads) &&
        isset($lead->_embedded->leads[0]) &&
        isset($lead->_embedded->leads[0]->id) &&
        $lead->_embedded->leads[0]->id > 0
    ) {
        $leadID = $lead->_embedded->leads[0]->id;


        $amo->LinkForLead($leadID, $user);
    }

}