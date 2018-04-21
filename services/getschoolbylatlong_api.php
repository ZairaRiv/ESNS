<?php

require_once ('/var/www/esns/phplibs/db.php');

$lat = $_GET["lat"];
$long = $_GET["long"];
$dist = $_GET["dist"];

$data = new ESNSData();
$data->SetReturnType("json");
$result = $data->GetSchoolByDist($lat,$long,$dist);

header('Content-Type: application/json');
echo $result;


