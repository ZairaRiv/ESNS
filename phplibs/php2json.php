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
$sql = "select schoolID,studentID, first,last,email from users where schoolID=0;";
$result = $conn->query($sql);


$output = array();
$output  = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($output);
$conn->close();

// agustin

