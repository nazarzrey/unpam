<?php
$servername = "localhost:3336";
$username = "root";
$password = "toor";
$dbname = "data_izin";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
