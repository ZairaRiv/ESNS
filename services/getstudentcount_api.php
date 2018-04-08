<?php

require_once ('/var/www/esns/phplibs/db.php');

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetTotalStudentCount();

header('Content-Type: application/json');
echo $result;


