<?php

require_once ('/var/www/esns/phplibs/db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];


$schoolID=$building["schoolID"];
$buildingID=$building["buildingID"];
$name=$building["name"];
$lat=$building["lat"];
$long=$building["long"];


$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->DeleteStructure($schoolID,$buildingID);
$result = $data->CreateStructure($schoolID,$buildingID,$name);
$result = $data->DeleteStructureLatLong($schoolID,$buildingID);
$result = $data->CreateStructureLatLong($schoolID,$buildingID,$lat,$long);

$succObj->success=true;

header('Content-Type: application/json');
echo json_encode($succObj);