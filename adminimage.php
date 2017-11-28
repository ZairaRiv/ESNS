<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 8:03 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();

$dbusername='';
$dbpasshash='';
$dbadminlevel=0;

if ($_COOKIE['cookiehash']!='' && $_COOKIE['username']) {
	$login=$data->HashLogin($_COOKIE['username'],$_COOKIE['cookiehash']);
	$row = $login->fetch_assoc();
	$dbusername = $row['username'];
	$dbpasshash = $row['passhash'];
	$dbadminlevel = $row['adminlevel'];

	if ($dbusername != '') {
		if ($_COOKIE['cookiehash']==$dbpasshash) {
			// nada
		}
		else {
			header("Location: /LogIn.html?");
			exit;
		}
	}
}
else {
	exit;
}


$perpBuildingID = $data->GetReports();
$studentBuildingID = $data->GetStudentLocations();
$buildingCount = 0;
$buildingShooterNumbers = array();
$buildingStudentNumbers = array();
$percH = array();
$percW = array();
$cropPadding=10; // pixels
$diameterPerp = array();
$diameterStudent = array();
$userdiam=20;

while ($row = $perpBuildingID->fetch_assoc()) {
	$bid=$row["buildingShooterID"];
	$diameterPerp[$bid]=$row["count(buildingShooterID)"];

	// get WxH data
	if (isset($percH[$bid])) {
		// nada to do here, we already have the data
	}
	else {
		// we don't have the data
		$widthHeighth= $data->GetWidthHeight($bid);
		$whrow = $widthHeighth->fetch_assoc();
		$percH[$bid]=$whrow["percentHeight"];
		$percW[$bid]=$whrow["percentWidth"];
	}
}

while ($row = $studentBuildingID->fetch_assoc()) {
	$bid=$row["buildingStudentID"];
	$diameterStudent[$bid]=$row["count(buildingStudentID)"];

	// get WxH data
	if (isset($percH[$bid])) {
		// nada to do here, we already have the data
	}
	else {
		// we don't have the data
		$widthHeighth= $data->GetWidthHeight($bid);
		$whrow = $widthHeighth->fetch_assoc();
		$percH[$bid]=$whrow["percentHeight"];
		$percW[$bid]=$whrow["percentWidth"];
	}
}



// You can't just do img_dot=img_orig.  Lame
$img_orig = imagecreatefromjpeg('/var/www/agustin/img/maps/csuf.jpg');
$img_dot  = imagecreatefromjpeg('/var/www/agustin/img/maps/csuf.jpg');

imagefilter($img_orig,IMG_FILTER_GRAYSCALE);
imagefilter($img_dot,IMG_FILTER_GRAYSCALE);

// we will go from yellow to red on shooter dots
$reportTimes = $data->GetReportTimes();
while ($row = $reportTimes->fetch_assoc()) {
	// top of the array, 0, is the most recent report
	// store the buildingID's so we can loop later without recalling the DB
	$bid=$row["buildingShooterID"];
	if (in_array($bid,$buildingShooterNumbers)){
		// nada
	}
	else{
		array_push($buildingShooterNumbers,$bid);
		$buildingCount++;
	}
}

$reportTimes = $data->GetStudentReportTimes();
while ($row = $reportTimes->fetch_assoc()) {
	// top of the array, 0, is the most recent report
	// store the buildingID's so we can loop later without recalling the DB
	$bid=$row["buildingStudentID"];
	if (in_array($bid,$buildingStudentNumbers)){
		// nada
	}
	else{
		array_push($buildingStudentNumbers,$bid);
	}
}

foreach ($buildingShooterNumbers as $n => $bid) {
	// we added yellow to the dot by adding green to the red in RGB
	$green=round(255*$n/$buildingCount);
	
	$dotHeight=imagesy($img_orig)*$percH[$bid];
	$dotWidth =imagesx($img_orig)*$percW[$bid];

	if (isset($diameterPerp[$bid])) {
		$diam = 50 + $diameterPerp[$bid]*5;
		if ($diam>150) {
			$diam=150; // size cap
		}
		$col_ellipse = imagecolorallocate($img_dot, 255, $green, 0);
		imagefilledellipse($img_dot, $dotWidth, $dotHeight, $diam, $diam, $col_ellipse);
	}
}

// level 10 = police, 5 = school admins
if ($dbadminlevel==10) {
	foreach ($buildingStudentNumbers as $n => $bid) {
		// we added yellow to the dot by adding green to the red in RGB
		$green=round(255*$n/$buildingCount);

		$dotHeight=imagesy($img_orig)*$percH[$bid];
		$dotWidth =imagesx($img_orig)*$percW[$bid];

		if (isset($diameterStudent[$bid])) {
			$diam = 50 + $diameterPerp[$bid]*5;
			if ($diam>35) {
				$diam=35; // size cap
			}
			$col_ellipse = imagecolorallocate($img_dot, 0, 255, 0);
			imagefilledellipse($img_dot, $dotWidth, $dotHeight, $diam, $diam, $col_ellipse);
		}
	}
}



// do user's building last to make sure the dot appears
$dotHeight=imagesy($img_orig)*$percH[$uid];
$dotWidth =imagesx($img_orig)*$percW[$uid];
$col_ellipse = imagecolorallocate($img_dot, 0, 255, 0);
imagefilledellipse($img_dot, $dotWidth, $dotHeight, $userdiam, $userdiam, $col_ellipse);



// create blank canvas at merged_image
$merged_image = imagecreatetruecolor(imagesx($img_orig), imagesy($img_orig));
imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

// copy onto merged_image the orig image
imagecopy($merged_image,$img_orig,0,0,0,0,imagesx($img_orig),imagesy($img_orig));

// allow alpha blending from this point on
imagealphablending($merged_image, true);
imagecopymerge($merged_image,$img_dot,0,0,0,0,imagesx($img_orig),imagesy($img_orig),50);

header('Content-Type: image/jpeg');
imagetruecolortopalette($merged_image, false, 64);
imagejpeg($merged_image);
imagedestroy($merged_image);
imagedestroy($merged_image);


