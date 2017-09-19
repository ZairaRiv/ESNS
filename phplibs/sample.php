<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 9/15/2017
 * Time: 5:26 AM
 */

$servername = "localhost";
$username = "esnsUser";
$password = "MrSharmaIsAlwaysLate";
$dbName = "esnsDB";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbName);

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// make a query
$sql = "SELECT name,title FROM usertest";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. "<br>Title: " . $row["title"] .  "<br><br>";
    }
} else {
    echo "0 results";
}
$conn->close();
