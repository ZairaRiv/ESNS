<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/16/2017
 * Time: 8:19 PM
 */

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="ESNS Landing Page">
	<title>ESNS</title>

	<link rel="stylesheet" href="CSS/pure.css">
	<link rel="stylesheet" href="CSS/grids-responsive-min.css">
	<link rel="stylesheet" href="CSS/pricing.css">
	<script>
        var numPages=2;
        function show(pageShown) {
            for (i=1; i<numPages+1; i++) {
                if (i==pageShown) {
                    document.getElementById(i).style.display='block';
                    console.log("Showing page "+i);
                }
                else {
                    document.getElementById(i).style.display='none';
                    console.log("Hidding page "+i);
                }
            }
        }
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                window.location.href = "/findschool.php";
            }
        }
        function showPosition(position) {
            window.location.href = "/report.php?lat="+position.coords.latitude + "&long=" + position.coords.longitude + "&dist=25";
        }
	</script>
</head>
<body>
<style>
	.custom-restricted-width {
		/* To limit the menu width to the content of the menu: */
		display: inline-block;
		/* Or set the width explicitly: */
		/* width: 10em; */
	}
</style>
<!-- HOME PAGE -->
<div class="pure-menu pure-menu-horizontal">
	<a href="#" class="pure-menu-heading"><!-- LOGO HERE --></a>
	<ul class="pure-menu-list">
		<li class="pure-menu-item"><a href="/" class="pure-menu-link">Home</a></li>
		<li class="pure-menu-item pure-menu-selected"><a href="About_US.html" class="pure-menu-link">About Us</a></li>
		<li class="pure-menu-item"><a href="Contact.html" class="pure-menu-link">Contact</a></li>
		<li class="pure-menu-item"><a href="login.php" class="pure-menu-link">Admin</a></li>
	</ul>
</div>

<div id="1">
	<div class="banner">
		<h1 class="banner-head">ESNS</h1>
	</div>
	<div>
		<center>
			<div class="pure-u-1 pure-u-md-1-3">
				<div class="pricing-table pricing-table-free">
					<div class="pricing-table-header">
						<h2>Make a</h2>
						<span class="pricing-table-price">
							REPORT
						</span>
					</div>
					<a href="#" onclick="return show('2');">
						<button class="button-choose pure-button">REPORT</button>
					</a>
				</div>
			</div>
		</center>
	</div>
</div>

<!-- REPORT -->
<div id="2" style="display:none">
	<div style="text-align: center;">
		<div id="main">
			<div class="header">
				<h1>We Need Your Location</h1>
			</div>
			<div class="content">
				Please click Allow/Yes after pressing "Find Me"<br>
				<a href="#" onclick="getLocation()">
					<button class="button-choose pure-button">Find Me</button>
				</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>

