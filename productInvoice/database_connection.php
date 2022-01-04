<?php
//database_connection.php
$servername = "localhost";
$username = "root";
$db = "testing4";

// Create connection
$conn = new mysqli($servername, $username, '' ,$db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>