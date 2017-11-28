<?php


require_once ('phplibs/db.php');


$lat = $_GET["lat"];
$long = $_GET["long"];
$dist = $_GET["dist"];

if (!$lat || !$long || !$dist) {
	header('Location: /');
	exit;
}

$data = new ESNSData();
$result = $data->GetSchoolByDist($lat,$long,$dist);
$row = $result->fetch_array(MYSQLI_ASSOC);
$firstSchoolID=$row["schoolID"];
$firstSchoolName=$row["schoolName"];

$reportElseId=$row["ID"];
$reportElseOption=$row["option"];


$optionsName = $data->GetListOption();

$buildings = $data->GetBuildingList($firstSchoolID);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript" src="JavaScript/report-else.js"></script>
<link rel="stylesheet" href="CSS/pure-min.css" integrity="sha384-" crossorigin="anonymous">
<link rel="stylesheet" href="CSS/grids-responsive-min.css">
<link rel="stylesheet" href="CSS/pricing.css">
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
      <div class="content"> We have located you at:
        <?php
					echo $firstSchoolName;
				?>
        <br>
        <a href="#" onclick="return show('2');">
        <button class="button-choose pure-button">Correct</button>
        </a> <a href="/findschool.php">
        <button class="button-choose pure-button">Incorrect</button>
        </a> <br>
        <?php
					if ($result->num_row > 0) {
						?>
        It is possible you're at... <br>
        <br>
        <?php
						while ($row = $result->fetch_assoc()) {
							echo '<a href="/atschool.php?schoolID=' + $row["schoolID"] + '">' + $row["schoolName"] + '</a><br>';
						}
					}
				?>
      </div>
    </div>
  </div>
</div>
<!-- FOUND SCHOOL --> 

<!-- else report--> 
<!-- else report options-->
<div id="2" style="display:none">
  <div style="text-align: center;">
    <div class="content">
      <h2 class="content-head is-center">What do you want to report?</h2>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list...">
      <br>
      <div class="pure-menu custom-restricted-width"> <br>
        <ul id="myUL" class="pure-menu-list">
          <li class="pure-menu-item"><a href="#" class="pure-menu-link">I Don't Know</a></li>
          
          <!-- read the file-->
          <?php
					while($row = $optionsName->fetch_assoc()) {
						echo '<li class="pure-menu-item"><a onclick="return show(\'3\');" href="#ReportOptionID=' .$row["ID"]. '" class="pure-menu-link">' . $row["opt"] .'</a></li>'."\n";
					}
					?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- choosing from the list-->
<div id="3" style="display:none">
  <div style="text-align: center;">
    <div class="content">
      <h2 class="content-head is-center">Where is the location?</h2>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list...">
      <br>
      <div class="pure-menu custom-restricted-width"> <br>
        <ul id="myUL" class="pure-menu-list">
          <li class="pure-menu-item"><a href="#" class="pure-menu-link">I Don't Know</a></li>
          <?php
					while($row = $buildings->fetch_assoc()) {
						echo '<li class="pure-menu-item"><a onclick="return show(\'4\');" href="#schoolID=' . $row["schoolID"] .
						'&buildingShooterID=' . $row["buildingID"] . '" class="pure-menu-link">' . $row["buildingName"] .
							'</a></li>'."\n";
					}  
					?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="4" style="display:none">
  <div style="text-align: center; background-color:#ccc">
    <div class="content">
      <h2 class="content-head is-center">Where are YOU at?</h2>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list...">
      <br>
      <div class="pure-menu custom-restricted-width"> <br>
        <ul id="myUL" class="pure-menu-list">
          <li class="pure-menu-item"><a href="#" class="pure-menu-link">I Don't Know</a></li>
          <?php

					$buildings = $data->GetBuildingList($firstSchoolID);
					while($row = $buildings->fetch_assoc()) {
						echo '<li class="pure-menu-item"><a onclick="url = window.location.href + \'&buildingStudentID='
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
<!-- choosing from the list--> 
<!-- else report-->

</body>
</html>
