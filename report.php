<?php
/**
 * Created by PhpStorm.
 * User: agustin and majid
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
$schoolID = $_GET["schoolID"];

$data = new ESNSData();
global $schools;

if (isset($schoolID)){
    $schools = $data->GetSchoolByID($schoolID);
}
else if ($lat && $long && $dist){
    $schools = $data->GetSchoolByDist($lat,$long,$dist);
}
else {
    header('Location: /');
    exit;
}

$buildings = $data->GetBuildingList($firstSchoolID);
$types = $data->GetListOption();

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ESNS Report Event">
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

        function makeList(listType,storeName,listTitle) {
            var buildings, text, i, schools,types, schoolID, loopList, _loopID, _loopName;
            schools = [<?php
                while ($row = $schools->fetch_assoc()) {
                    echo '"' . $row["schoolID"] . ':' . $row["schoolName"] . '",';
                }
                echo '"999:None of the Above"';
                ?>];

            types = [<?php
                while ($row = $types->fetch_assoc()) {
                    echo '"' . $row["ID"] . ':' . $row["opt"] . '",';
                }
                echo '"999:None of the Above"';
                ?>];

            buildings = [<?php
                while ($row = $buildings->fetch_assoc()) {
                    echo '"' . $row["buildingID"] . ':' . $row["buildingName"] . '",';
                }
                echo '"999:None of the Above"';
                ?>];

            if (listType == "schools") {
                loopList=schools;
            }
            else if (listType == "types") {
                loopList=types;
            }
            else if (listType == "buildings") {
                loopList=buildings;
            }


            text = '<div class="header"><h1>' + listTitle + '</h1></div>';
            text +='<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Narrow the list..."><br>';
            text += '<ul id="myUL" class="pure-menu-list">' + "\n";
            for (i = 0; i < loopList.length; i++) {
                var spltStr = loopList[i].split(":");
                console.log(spltStr.length);
                if (spltStr.length > 2 ){
                    schoolID=localStorage.getItem("schoolID");
                    if (schoolID != spltStr[0]) continue;
                    console.log(schoolID);
                    console.log(spltStr[0]);
                    _loopID=spltStr[1];
                    _loopName=spltStr[2];
                }
                else {
                    _loopID=spltStr[0];
                    _loopName=spltStr[1];
                }
                text += '<li class="pure-menu-item"><a onclick="storePair(\'' + storeName + "','" + _loopID +"')\"";
                text += ' class="pure-menu-link" href="#">';
                text += _loopName + '</a></li>';
            }
            text += "</ul>";

            return text;
        }

        function storePair(index,val) {
            localStorage.setItem(index, val);
            if (index == "schoolID"){
                document.getElementById("LISTS").innerHTML = makeList("types","typeID","Type of Event");
            }
            else if (index == "typeID"){
                document.getElementById("LISTS").innerHTML = makeList("buildings","perpBuildingID","Where is this occurring?");
            }
            else if (index == "perpBuildingID") {
                document.getElementById("LISTS").innerHTML = makeList("buildings","userBuildingID","Where are YOU");
            }
            else if (index == "userBuildingID") {
                var schoolID=localStorage.getItem("schoolID");
                var perpBuildingID=localStorage.getItem("perpBuildingID");
                var userBuildingID=localStorage.getItem("userBuildingID");
                var typeID=localStorage.getItem("typeID");
                window.location.href = "sendreport.php?schoolID=" + schoolID + "&perpBuildingID=" + perpBuildingID + "&userBuildingID=" + userBuildingID + "&typeID=" + typeID;
            }
        }

        window.onload = function(){
            gotime();
            function gotime(){
                <?php
                if (isset($schoolID)) {
                    echo 'document.getElementById("LISTS").innerHTML = makeList("buildings","perpBuildingID","Where is this occurring?");';
                }
                else {
                    echo 'document.getElementById("LISTS").innerHTML = makeList("schools", "schoolID", "Your Location");';
                }
                ?>
            }
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
    <link rel="stylesheet" href="CSS/pure-min.css" integrity="sha384-" crossorigin="anonymous">

    <link rel="stylesheet" href="CSS/grids-responsive-min.css">
    <link rel="stylesheet" href="CSS/pricing.css">
</style>



<div style="text-align: center;">
    <div id="main">
        <div class="content">
            <div id="LISTS"></div>
        </div>
    </div>

</body>
</html>


