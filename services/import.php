<?php

// import points and buildings from URL

require_once ('/var/www/esns/phplibs/db.php');
$json = file_get_contents('points.json');
$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);

$points = json_decode($json);

$data = new ESNSData();
$schoolID = 0 ;

/*
$this->DeleteBuilding($schoolID,$buildingID);
        $this->CreateStructure($schoolID,$buildingID,$buildingName);
        $this->CreateStructureLatLong($schoolID,$buildingID,$lat,$long);
		$this->CreateStructureDimensions($schoolID,$buildingID,$point,$width,$height,$start,$end);
		*/

foreach ($points as $key => $value) { 
	$data->DeleteBuilding($schoolID,$value->id);
	if (preg_match('/Parking|Kiosk|Pay for Print|Dispenser|Student Services|Study Area|Phone|PHIL/',$value->title) || !(is_numeric($value->id))) {
		echo "Skipping ";
		echo "$value->title\n";
	}
	else {
		echo "Inserting ";
		echo "$value->title\n";
		$data->CreateStructure($schoolID,$value->id,$value->title);
		$data->CreateStructureLatLong($schoolID,$value->id, $value->lat, $value->lng);
		$data->CreateStructureDimensions($schoolID,$value->id,'0','0','0','true','false');
	}
	

	
}

