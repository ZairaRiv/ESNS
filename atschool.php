<!DOCTYPE html>
<html>
<body>

<p>We need your coordinates in order to find your school.</p>
<button onclick="getLocation()">Give us your location</button>

<p id="demo"></p>

<script>
    var x = document.getElementById("demo");
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude +
            "<BR><BR><a href=\"/findschool.php?lat=" + position.coords.latitude +
            "&long=" + position.coords.longitude +
            "&dist=25\">Go to your school</a>"
    }
</script>

</body>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 9/30/2017
 * Time: 11:49 AM
 */