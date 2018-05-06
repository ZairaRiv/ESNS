<?php

require_once ('/var/www/esns/phplibs/db.php');

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->ClearReports();

header('Content-Type: application/json');
$succObj->success=true;
echo json_encode($succObj);
