<?php

require_once ('phplibs/db.php');

// schoolID=0&shooterBuildingID=11studentBuildingID=21
$schoolID = $_GET["schoolID"];
$studentID = $_GET["studentID"];
$prepBuildingID = $_GET["perpBuildingID"];
$userBuildingID= $_GET["userBuildingID"];
$typeID=$_GET["typeID"];

$data = new ESNSData();
$data->MakeReport($schoolID,$studentID,$prepBuildingID,$userBuildingID,$typeID);

header("Location: /map.php?schoolID=$schoolID");



