<?php

require_once ('/var/www/esns/phplibs/db.php');

$studentID = $_GET["studentID"];
$safety = $_GET["safety"];

$data = new ESNSData();
$data->SetReturnType("json");

$succObj = new \stdClass();

if (isset($studentID) && isset($safety)) {
	$result = $data->SafetyReport($studentID, $safety);
	$succObj->success=true;
}
else {
	$succObj->success=false;;
}


header('Content-Type: application/json');
echo json_encode($succObj);


