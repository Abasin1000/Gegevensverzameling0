<?php
//verbinding database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boxers_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
