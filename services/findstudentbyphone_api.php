<?php

require_once ('/var/www/esns/phplibs/db.php');

$phone = $_GET["phone"];
$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->FindStudentByPhone($phone);

header('Content-Type: application/json');
echo $result;


