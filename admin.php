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
			setcookie('username', $dbusername, time() + (86400 * 7), '/', 'esns.life');
			setcookie('cookiehash', $dbpasshash, time() + (86400 * 7), '/', 'esns.life');
		}
		else {
			header("Location: /login.php?Login=F");
			exit;
		}
	}
}
else if ($_COOKIE['cookiehash']!='' && $_COOKIE['username']!='') {
	$login=$data->HashLogin($_COOKIE['username'],$_COOKIE['cookiehash']);
	$row = $login->fetch_assoc();
	$dbusername = $row['username'];
	$dbpasshash = $row['passhash'];
	$dbadminlevel = $row['adminlevel'];

	if ($dbusername != '') {
		if ($_COOKIE['cookiehash']==$dbpasshash) {
			// nada
		}
		else {
			header("Location: /login.php?");
			exit;
		}
	}
}
else {
	header("Location: /login.php?");
	exit;
}

$mode=$data->CheckEmergencyMode();
$row = $mode->fetch_assoc();
$enabled=$row["enabled"];

?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="ESNS Report Event">
	<title>ESNS</title>

	<link rel="stylesheet" href="CSS/pure-min.css" integrity="sha384-" crossorigin="anonymous">
	<link rel="stylesheet" href="CSS/grids-responsive-min.css">
	<link rel="stylesheet" href="CSS/pricing.css">
	<style>
		/* For this demo only */
		.container {
			max-height: 95%;
			margin: 0 auto;
			height: auto;
		}
		.img-frame {
			background: #fff;
			margin: 20px auto;
		}

		/* This is for responsive container with specified aspect ratio */
		.aspect-ratio {
			padding-bottom: 100%;
		}

		/* This is the key part - position and fit the image to the container */
		.fit-img {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			margin: auto;
			max-width: 100%;
			max-height: 100%
		}
	</style>
</head>
<body>

<div class="pure-menu pure-menu-horizontal">
	<?php
		echo " &nbsp; &nbsp; " . $dbusername;
		echo " (Level:" . $dbadminlevel . ") ";
		echo " | ";
	?>
	<ul class="pure-menu-list">
		<li class="pure-menu-item"><a href="/" class="pure-menu-link">Home</a></li>
		<li class="pure-menu-item"><a href="clearreports.php" class="pure-menu-link">Clear Reports</a></li>
		<li class="pure-menu-item"><a href="fakereports.php" class="pure-menu-link">Fake Reports</a></li>
		<?php
		if ($enabled<1) {
			echo '<li class="pure-menu-item"><a href="enable.php" class="pure-menu-link">Enable Emergency Mode</a></li>';
		}
		else {
			echo '<li class="pure-menu-item"><a href="disable.php" class="pure-menu-link">Disable Emergency Mode</a></li>';
		}
		?>
		<li class="pure-menu-item"><a href="LogOut.php" class="pure-menu-link">Log Out</a></li>
	</ul>
</div>

<div style="text-align: center;">
	<div class="container">
		<div class="aspect-ratio img-frame">
			<img src="adminimage.php" class="fit-img">
		</div>
	</div>
</div>
</body>
</html>






