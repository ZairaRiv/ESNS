<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/12/2017
 * Time: 3:39 PM
 */

// You can't just do img_dot=img_orig.  Lame
$img_orig = imagecreatefromjpeg('img/esnsbackground.jpg');

header('Content-Type: image/jpeg');
imagejpeg($img_orig);
imagedestroy($img_orig);



