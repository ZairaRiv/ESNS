<?php

require_once ('/var/www/esns/phplibs/db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];

error_log(json_decode($building),0);

$schoolID=$building["schoolID"];
$buildingID=$building["buildingID"];
$name=$building["name"];
$lat=$building["lat"];
$long=$building["long"];

//error_log($buildingID,0);
//$obj = get_object_vars($building);
//error_log($building["schoolID"],0);

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->DeleteStructure($schoolID,$buildingID);
$result = $data->CreateStructure($schoolID,$buildingID,$name);
$result = $data->DeleteStructureLatLong($schoolID,$buildingID);
$result = $data->CreateStructureLatLong($schoolID,$buildingID,$lat,$long);


header('Content-Type: application/json');
echo '"success": true';