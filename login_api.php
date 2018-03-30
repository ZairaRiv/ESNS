<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 6:36 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();


$username = $_POST["username"];
$password = $_POST["password"];

$myObj->username = $username;
$myObj->password = $password;

$dbusername='';
$dbpasshash='';
$dbadminlevel='';

if ($username && $password) {
	$login = $data->UserLogin($username, $password);
	$row = $login->fetch_assoc();
	$dbusername = $row['username'];
	$dbpasshash = $row['passhash'];
	$dbadminlevel = $row['adminlevel'];

	if ($dbusername != '') {
		if (password_verify($password, $dbpasshash)) {
			setcookie('username', $dbusername, time() + (86400 * 7), '/', 'esns.life', false);
			setcookie('cookiehash', $dbpasshash, time() + (86400 * 7), '/', 'esns.life', false);
		} else {
		}
	}
}

echo json_encode($myObj);
