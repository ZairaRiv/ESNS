<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 6:36 PM
 */

require_once ('/var/www/esns/phplibs/db.php');
$data = new ESNSData();

$myObj->success = false;
$inOrOut = $_GET["ioo"];

if ($inOrOut=="out") {
	setcookie('cookiehash', '', time() + (1));
	echo json_encode($myObj);
	exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);

$username = $_POST["username"];
$password = $_POST["password"];



$dbusername='';
$dbpasshash='';
$dbadminlevel='';

if ($password == '') {
	$myObj->message = "Password field empty";
}
else if ($username == '') {
	$myObj->message = "Username field empty";
}
else if ($username && $password) {
	$login = $data->UserLogin($username, $password);
	$row = $login->fetch_assoc();
	$dbusername = $row['username'];
	$dbpasshash = $row['passhash'];
	$dbadminlevel = $row['adminlevel'];

	if ($dbusername != '') {
		if (password_verify($password, $dbpasshash)) {
			setcookie('username', $dbusername, time() + (86400 * 7), '/');
			setcookie('cookiehash', $dbpasshash, time() + (86400 * 7), '/');
			$myObj->username = $dbusername;
			$myObj->cookiehash = $dbpasshash;
			$myObj->adminlevel = $dbadminlevel;
			$myObj->success = true;
		} else {
			$myObj->message = "Invalid credentials";
		}
	}
	else {
		$myObj->message = "Invalid credentials";
	}
}



echo json_encode($myObj);
