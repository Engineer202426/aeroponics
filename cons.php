<?php
// Step 1: Connect to the database
$host = 'localhost'; // or your host
$username = 'root'; // your database username
$password = ''; // your database password
$database = 'aeroponics'; // your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>