<?php

$servername = "localhost";
$username = "id21963635_odoruame";
$password = "Softmist#56"; 
$dbname = "id21963635_personalwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>