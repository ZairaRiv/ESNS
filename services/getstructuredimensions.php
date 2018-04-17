<?php

require_once ('/var/www/esns/phplibs/db.php');

$schoolID = $GET["schoolID"];
$buildingID = $GET["buildingID"];

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetStructures($schoolID,$buildingID);

header('Content-Type: application/json');
echo $result;


