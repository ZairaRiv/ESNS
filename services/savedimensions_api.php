<?php

$_POST = json_decode(file_get_contents('php://input'), true);
$building = $_POST["building"];

error_log(json_encode($building),0);
//$obj = get_object_vars($building);

error_log($building->schoolID,0);


header('Content-Type: application/json');
echo json_encode($building);
