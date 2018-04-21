<?php

require_once ('/var/www/esns/phplibs/db.php');

$schoolID = $_GET["schoolID"];
$buildingID = $_GET["buildingID"];

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetStructureDimensions($schoolID,$buildingID);

header('Content-Type: application/json');
echo $result;


