<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/12/2017
 * Time: 3:39 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();

$mode=$data->CheckEmergencyMode();
$row = $mode->fetch_assoc();
$enabled=$row["enabled"];

if ($enabled<1) {
	$img_orig = imagecreatefromjpeg('img/esnsbackground.jpg');
	header('Content-Type: image/jpeg');
	imagejpeg($img_orig);
}
else {
	$img_orig = imagecreatefrompng('img/small.png');
	header('Content-Type: image/png');
	imagepng($img_orig);
}


imagedestroy($img_orig);



