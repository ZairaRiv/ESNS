<?php

require_once ('/var/www/esns/phplibs/db.php');
header('Content-Type: application/json');

$reportTime = $_GET["reportTime"];
$reportType = $_GET["reportType"];
$schoolID = $_GET["schoolID"];

$data = new ESNSData();
$data->SetReturnType("json");

if (isset($reportType) && $reportType != 0 ) {
	$result = $data->GetLatestReports($schoolID, $reportType, $reportTime);
}
else {
	$result = $data->GetAllReports($schoolID, $reportType);
}

echo $result;