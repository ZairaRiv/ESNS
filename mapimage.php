<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/12/2017
 * Time: 3:39 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();
$perpBuildingID = $data->GetReports();
$buildingCount = 0;
$buildingNumbers = array();
$percH = array();
$percW = array();
$cropPadding=10; // pixels
$diameter = array();
$userdiam=50;

$uid= $_GET["uID"];
//$uid=11;

// get user's buildingID info and add to array first
$widthHeighth= $data->GetWidthHeight($uid);
$whrow = $widthHeighth->fetch_assoc();
$percH[$uid]=$whrow["percentHeight"];
$percW[$uid]=$whrow["percentWidth"];

while ($row = $perpBuildingID->fetch_assoc()) {
    $bid=$row["buildingShooterID"];
	$diameter[$bid]=$row["count(buildingShooterID)"];

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

// set the max to 0, the min to max, guaranteeing they will be adjusted in the loop below
$maxH=0;
$maxW=0;
$minH=imagesy($img_orig);
$minW=imagesx($img_orig);

// we will go from yellow to red on shooter dots
$lastReportTime=array();
$reportTimes = $data->GetReportTimes();
while ($row = $reportTimes->fetch_assoc()) {
	// top of the array, 0, is the most recent report
	// store the buildingID's so we can loop later without recalling the DB
	$bid=$row["buildingShooterID"];
	if (in_array($bid,$buildingNumbers)){
		// nada
	}
	else{
		array_push($buildingNumbers,$bid);
		$buildingCount++;
	}


}
foreach ($buildingNumbers as $n => $bid) {
	// we added yellow to the dot by adding green to the red in RGB
	$green=round(255*$n/$buildingCount);

	//echo "bid: $bid => $green\n";
    $dotHeight=imagesy($img_orig)*$percH[$bid];
    $dotWidth =imagesx($img_orig)*$percW[$bid];

    $diam = 50 + $diameter[$bid]*5;
	// also user's building, set minimum diameter to make sure it's visible under the user dot
	if ($bid==$uid) {
		if ($diam<100) {
			$diam=100;
		}
    }

    if ($diam>150) {
        $diam=150; // size cap
    }

	if ($dotHeight+$diam/2>$maxH) {
		$maxH=$dotHeight+$diam/2;
	}
	if ($dotHeight-$diam/2<$minH) {
		$minH=$dotHeight-$diam/2;
	}
	if ($dotWidth+$diam/2>$maxW) {
		$maxW=$dotWidth+$diam/2;
	}
	if ($dotWidth-$diam/2<$minW) {
		$minW=$dotWidth-$diam/2;
	}

    $col_ellipse = imagecolorallocate($img_dot, 255, $green, 0);
    imagefilledellipse($img_dot, $dotWidth, $dotHeight, $diam, $diam, $col_ellipse);
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


// add some padding
$minW -=$cropPadding;
$maxW +=$cropPadding;
$minH -=$cropPadding;
$maxH +=$cropPadding;
// make sure we don't crop beyond the image boundaries (resulting in an error)
if ($minW<0) {
	$minW=0;
}
if ($maxW>imagesx($img_orig)) {
	$maxW=imagesx($img_orig);
}
if ($minH<0) {
	$minH=0;
}
if ($maxH>imagesy($img_orig)) {
	$maxH=imagesy($img_orig);
}

// crop image
$croppedImage=imagecrop($merged_image, ['x'=>$minW, 'y'=>$minH, 'width'=>$maxW-$minW, 'height'=>$maxH-$minH]);

header('Content-Type: image/jpeg');
imagetruecolortopalette($merged_image, false, 64);
imagejpeg($croppedImage);
imagedestroy($croppedImage);
imagedestroy($merged_image);



