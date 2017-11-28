<?php

require_once ('phplibs/db.php');

$data = new ESNSData();

$data->ClearReports();
$data->FakeReports();
/**
echo "<br>\n";

$makeFakes=array();

array_push($makeFakes,30);
array_push($makeFakes,48);
array_push($makeFakes,1);
array_push($makeFakes,26);
array_push($makeFakes,47);
array_push($makeFakes,55);
array_push($makeFakes,12);
array_push($makeFakes,18);
array_push($makeFakes,54);
array_push($makeFakes,69);
array_push($makeFakes,46);
array_push($makeFakes,16);
array_push($makeFakes,34);
array_push($makeFakes,43);
array_push($makeFakes,2);


foreach ($makeFakes as $n => $bid) {
	echo "$n => $bid\n";
	for ($i=0; $i<$n+2;$i++) {
		$buildingStudentID= rand ( 0 , 40 );
		$data->MakeReport(0,1,$bid,$buildingStudentID,1);
		echo "<br>\n";
	}
	usleep(1250000);
}
//
 **/
header("Location: /admin.php");



