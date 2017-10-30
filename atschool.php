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
// pretty: view-source:https://agustin.esns.life/findschool.php?lat=36.8228972&long=-119.7597301&dist=25
$lat = $_GET["lat"];
$long = $_GET["long"];
$dist = $_GET["dist"];

// if these three required params are missing, redirect back to the home page
if (!$lat || !$long || !$dist) {
	header('Location: /');
	exit;
}

$data = new ESNSData();
$result = $data->GetSchoolByDist($lat,$long,$dist);
$row = $result->fetch_array(MYSQLI_ASSOC);
$firstSchoolID=$row["schoolID"];
$firstSchoolName=$row["schoolName"];

$buildings = $data->GetBuildingList($firstSchoolID);

?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="ESNS Landing Page">
	<title>ESNS</title>

	<link rel="stylesheet" href="CSS/pure-min.css" integrity="sha384-" crossorigin="anonymous">
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="CSS/grids-responsive-old-ie-min.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
	<link rel="stylesheet" href="CSS/grids-responsive-min.css">
	<!--<![endif]-->
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="CSS/layouts/pricing-old-ie.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
	<link rel="stylesheet" href="CSS/pricing.css">
	<!--<![endif]-->
	<script>
        var numPages=3;
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

        function myFunction() {
            // Declare variables
            var input, filter, ul, li, a, i;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function redir(url) {
            url = encodeURI(url);
            url = url.replace(/#/g, '&');
            url = url.replace(/atschool/, 'sendreport');
            window.location.href = url;
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

<!-- FOUND SCHOOL -->
<div id="1">
	<div style="text-align: center;">
		<div id="main">
			<div class="header">
				<h1>Your Location</h1>
			</div>

			<div class="content">
				We have located you at:
				<?php
					echo $firstSchoolName;
				?>
				<br>
				<a href="#" onclick="return show('2');">
					<button class="button-choose pure-button">Correct</button>
				</a>
				<a href="/findschool.php">
					<button class="button-choose pure-button">Incorrect</button>
				</a> <br>
				<?php
					if ($result->num_row > 0) {
						?> It is possible you're at... <br><br> <?php
						while ($row = $result->fetch_assoc()) {
							echo '<a href="/atschool.php?schoolID=' + $row["schoolID"] + '">' + $row["schoolName"] + '</a><br>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

<!-- shooter location -->
<div id="2" style="display:none">
	<div style="text-align: center;">
		<div class="content">
			<h2 class="content-head is-center">Where is the shooter?</h2>

			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list..."><br>
			<div class="pure-menu custom-restricted-width">
				<br>
				<ul id="myUL" class="pure-menu-list">
					<li class="pure-menu-item"><a href="#" class="pure-menu-link">I Don't Know</a></li>
					<?php
					while($row = $buildings->fetch_assoc()) {
						echo '<li class="pure-menu-item"><a onclick="return show(\'3\');" href="#schoolID=' . $row["schoolID"] .
						'&shooterBuildingID=' . $row["buildingID"] . '" class="pure-menu-link">' . $row["buildingName"] .
							'</a></li>'."\n";
					}
					?>
				</ul>

			</div>
		</div>
	</div>
</div>

<div id="3" style="display:none">
	<div style="text-align: center;">
		<div class="content">
			<h2 class="content-head is-center">Where are YOU?</h2>

			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list..."><br>
			<div class="pure-menu custom-restricted-width">
				<br>
				<ul id="myUL" class="pure-menu-list">
					<li class="pure-menu-item"><a href="#" class="pure-menu-link">I Don't Know</a></li>
					<?php

					$buildings = $data->GetBuildingList($firstSchoolID);
					while($row = $buildings->fetch_assoc()) {
						echo '<li class="pure-menu-item"><a onclick="url = window.location.href + \'studentBuildingID='
							. $row["buildingID"] .
							'\';" href="javascript:redir(url);" class="pure-menu-link">' . $row["buildingName"] .
							'</a></li>'."\n";
					}
					?>
				</ul>

			</div>
		</div>
	</div>
</div>

</body>
</html>


