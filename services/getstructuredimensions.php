<?php

require_once ('/var/www/esns/phplibs/db.php');
header('Content-Type: application/json');

$schoolID = $_GET["schoolID"];
$buildingID = $_GET["buildingID"];

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetStructureDimensions($schoolID,$buildingID);


echo $result;


