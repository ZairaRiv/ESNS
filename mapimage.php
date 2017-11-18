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
$buildingCount = array();
$buildingNumbers = array();
$percH = array();
$percW = array();
$radius = array();

while ($row = $perpBuildingID->fetch_assoc()) {
    $bid=$row["buildingShooterID"];
	$radius[$bid]=$row["count(buildingShooterID)"];

	// store the buildingID's so we can loop later without recalling the DB
    $buildingNumbers[$bid]=1;

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
$img_dot=imagecreatefromjpeg('/var/www/agustin/img/maps/csuf.jpg');

foreach ($buildingNumbers as $bid => $notUseful) {
    $dotHeight=imagesy($img_orig)*$percH[$bid];
    $dotWidth =imagesx($img_orig)*$percW[$bid];

    $radi = 50 + $radius[$bid]*10;
    if ($radi>300) {
        $radi=300; // size cap
    }

    $col_ellipse = imagecolorallocate($img_dot, 255, 0, 0);
    imagefilledellipse($img_dot, $dotWidth, $dotHeight, $radi, $radi, $col_ellipse);
}


// create blank canvas at merged_image
$merged_image = imagecreatetruecolor(imagesx($img_orig), imagesy($img_orig));
imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

// copy onto merged_image the orig image
imagecopy($merged_image,$img_orig,0,0,0,0,imagesx($img_orig),imagesy($img_orig));

// allow alpha blending from this point on
imagealphablending($merged_image, true);
imagecopymerge($merged_image,$img_dot,0,0,0,0,imagesx($img_orig),imagesy($img_orig),50);

header('Content-Type: image/gif');
imagetruecolortopalette($merged_image, false, 64);
imagegif($merged_image);
imagedestroy($merged_image);



