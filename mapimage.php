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

while ($row = $perpBuildingID->fetch_assoc()) {
    $bid=$row["buildingShooterID"];

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


    // count the # of times the building has been reported, set into array
    if (isset($dotsOnMap[$bid])){
        $buildingCount[$bid]++;
    }
    else{
        $buildingCount[$bid]=1;
    }

}

//$size = min(imagesx($img), imagesy($img));

// You can't just do img_dot=img_orig.  Lame
$img_orig = imagecreatefromjpeg('/var/www/agustin/img/maps/csuf.jpg');
$img_dot=imagecreatefromjpeg('/var/www/agustin/img/maps/csuf.jpg');

foreach ($buildingNumbers as $bid => $notUseful) {
    $dotHeight=imagesy($img_orig)*$percH[$bid];
    $dotWidth =imagesx($img_orig)*$percW[$bid];
/**
    echo imagesx($img_orig);
    echo "* $percW[$bid] \n";

    echo imagesy($img_orig);
    echo "* $percH[$bid] \n";

    echo "$dotWidth x $dotHeight\n\n";
 **/
    $radius = $buildingCount[$bid]*10;
    if ($radius>150) {
        $radius=100; // size cap
    }
    if ($radius<50) {
        $radius=50; // size min
    }
    $col_ellipse = imagecolorallocate($img_dot, 255, 0, 0);
    imagefilledellipse($img_dot, $dotWidth, $dotHeight, $radius, $radius, $col_ellipse);
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



