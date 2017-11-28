<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 9:05 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();

if ($_COOKIE['cookiehash']!='' && $_COOKIE['username']) {
	$login=$data->HashLogin($_COOKIE['username'],$_COOKIE['cookiehash']);
	$row = $login->fetch_assoc();
	$dbusername = $row['username'];
	$dbpasshash = $row['passhash'];
	$dbadminlevel = $row['username'];

	if ($dbusername != '') {
		if ($_COOKIE['cookiehash'] == $dbpasshash) {
			// nada
		} else {
			header("Location: /LogIn.html?");
			exit;
		}
	}
}

$data->DisableEmergencyMode();
header("Location: /admin.php");