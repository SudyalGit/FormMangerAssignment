<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("DATABASE CONNECTION FAILED: " . $conn->connect_error);
}
// echo "DATABASE CONNECTED";
