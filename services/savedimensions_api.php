<?php

require_once ('/var/www/esns/phplibs/db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];

$schoolID=$building["schoolID"];
$buildingID=$building["buildingID"];
$dimensions = $building["dimensions"];

//error_log($buildingID,0);
//$obj = get_object_vars($building);
//error_log($building["schoolID"],0);

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->DeleteStructureDimensions($schoolID,$buildingID);

error_log('--------------', 0);
foreach($dimensions as $d) {
    error_log($d["p"]);
    $result = $data->CreateStructureDimensions($schoolID,$buildingID,$d["p"],$d["w"],$d["h"],$d["s"],$d["e"]);
}


header('Content-Type: application/json');

echo '"success": true';