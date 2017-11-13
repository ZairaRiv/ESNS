<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/2/2017
 * Time: 9:12 AM
 */


$im = imagecreatefrompng('/var/www/agustin/img/maps/csuf.png');
$size = min(imagesx($im), imagesy($im));
$im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
if ($im2 !== FALSE) {
	imagepng($im2, '/var/www/agustin/img/maps/example-cropped.png');
}

