<?php

require_once ('/var/www/esns/phplibs/db.php');

$partialName = $_GET["partialname"];
$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->FindStudentByPartialName($partialName);

header('Content-Type: application/json');
echo $result;


