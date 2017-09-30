<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 9/30/2017
 * Time: 10:08 AM
 */

require_once ('phplibs/db.php');

// passed parameters from the URL
// example query is
// https://agustin.esns.life/findschool.php?lat=36.8228972&long=-119.7597301&dist=25
$lat = $_GET["lat"];
$long = $_GET["long"];
$dist = $_GET["dist"];

$data = new ESNSData();
$result = $data->GetSchoolByDist($lat,$long,$dist);
$data->JSONifyResults($result);
