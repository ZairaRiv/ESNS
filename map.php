<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 10/30/2017
 * Time: 10:13 PM
 */

$schoolID = $_GET["schoolID"];

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
        function getImage() {
            var userBuildingID=localStorage.getItem("userBuildingID");
            var text = '<img src="mapimage.php?uID=' + userBuildingID + '">';
            return text;
        }

        window.onload = function(){
            gotime();
            function gotime(){
                document.getElementById("MAPIMAGE").innerHTML = getImage();
            }
        }



    </script>
</head>
<body>
    <div style="text-align: center;">
    <div id="main">
        <div class="content">
            <div id="MAPIMAGE"></div>
        </div>
        <?php
            echo '<a href="report.php?schoolID=' . $schoolID . '">Make New Report</a>';
        ?>
    </div>

</body>
</html>