<?php

require_once ('phplibs/db.php');

// schoolID=0&shooterBuildingID=11studentBuildingID=21
$schoolID = $_GET["schoolID"];
$studentID = $_GET["studentID"];
$buildingShooterID = $_GET["buildingShooterID"];
$buildingStudentID= $_GET["buildingStudentID"];

$data = new ESNSData();
$data->MakeReport($schoolID,$studentID,$buildingShooterID,$buildingStudentID);

header('Location: /map.php');



