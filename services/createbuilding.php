<?php

require_once ('/var/www/esns/phplibs/db.php');
$_POST = json_decode(file_get_contents('php://input'), true);

$schoolID = $_POST["schoolID"];
$


$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->FindStudentByPartialName($partialName);

header('Content-Type: application/json');
echo $result;


