<?php

require_once ('/var/www/esns/phplibs/db.php');
header('Content-Type: application/json');

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];

$lat = $building["lat"];
$long = $building["long"];
$buildingName = $building["buildingName"];
$schoolID = $building["schoolID"];

$data = new ESNSData();
$data->SetReturnType("json");

if (isset($schoolID) && isset($buildingName) && isset($lat) && isset($long)){
	$result = $data->CreateStructureFromScratch($schoolID,$buildingName,$lat,$long);
	if ($result == '') {
		$succObj->success=true;
	}
	else {
		$succObj->success=false;
	}
	echo json_encode($succObj);
}
