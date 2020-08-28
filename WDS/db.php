<?php 

$servername = "localhost:3305";		// Change the port or remove it here if gives error.
$username = "root";
$password = "";
$dbname = "db_proj_final";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




 ?>