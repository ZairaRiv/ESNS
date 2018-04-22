<?php

require_once ('/var/www/esns/phplibs/db.php');

#$schoolID = $_GET["schoolID"];
$schoolID = 0;

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetAllStructuresDimensions($schoolID);

header('Content-Type: application/json');
echo $result;