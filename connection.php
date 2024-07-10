<?php
$username = 'root';
$password = ''; 
$server = 'localhost';
$db = 'attendanceclasswise';

$connection = mysqli_connect($server, $username, $password, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
