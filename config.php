<?php
// Database configuration
$host = "localhost";
$user = "root";        // change if hosting server
$password = "";        // change if hosting server
$database = "rpms";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
