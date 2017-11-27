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
    <link rel="stylesheet" href="CSS/grids-responsive-min.css">
    <link rel="stylesheet" href="CSS/pricing.css">

    <script>
        function getImage() {
            var userBuildingID=localStorage.getItem("userBuildingID");
            var text = '<img src="mapimage.php?uID=' + userBuildingID + '" class="fit-img">';
            return text;
        }

        window.onload = function(){
            gotime();
            function gotime(){
                document.getElementById("MAPIMAGE").innerHTML = getImage();
            }
        }
    </script>
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
    <div style="text-align: center;">
    <!--div-- id="main">
        <div class="content">
            <div id="MAPIMAGE"></div>
        </div>

    </div-->
	    <?php
	    echo '<a href="report.php?schoolID=' . $schoolID . '">Make New Report</a>';
	    ?>
	    <div class="container">

		    <div class="aspect-ratio img-frame">
			    <div id="MAPIMAGE">
			    </div>
		    </div>

	    </div>


    </div>
</body>
</html>