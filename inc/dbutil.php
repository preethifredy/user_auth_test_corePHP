<?php
$dbhost = 'localhost';
$dbname = "kingslabs_test";
$dbusername = 'root';
$dbuserpassword = '';
// Create connection
$conn = new mysqli($dbhost, $dbusername, $dbuserpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
