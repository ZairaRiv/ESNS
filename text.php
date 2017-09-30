<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 9/30/2017
 * Time: 11:32 AM
 */

require_once ('phplibs/db.php');

// passed parameters from the URL
// example query is
// https://agustin.esns.life/text.php?schoolID=0
// pretty: view-source:https://agustin.esns.life/text.php?schoolID=0
$schoolID = $_GET["schoolID"];

$data = new ESNSData();
$result = $data->GetStudents($schoolID);
$data->JSONifyResults($result);
