<?php

require_once ('/var/www/esns/phplibs/db.php');
header('Content-Type: application/json');

$schoolID = $_GET["schoolID"];

$data = new ESNSData();
$data->SetReturnType("json");

$result = $data->GetCompiledShootingReports($schoolID);

echo $result;