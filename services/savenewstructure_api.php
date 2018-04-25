<?php

require_once ('/var/www/esns/phplibs/db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];

error_log($building["buildingName"],0);

$buildingName=$building["buildingName"];
$schoolID=$building["schoolID"];

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->CreateStructureFromScratch($schoolID,$buildingName);

error_log($result);

$succObj->success=true;

header('Content-Type: application/json');
echo json_encode($succObj);