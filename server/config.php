<?php
$servername = "localhost";
$username = "root";
$password = "Admin";
$dbname = "ticket_syst";

// koble til databasen
$link = new mysqli($servername, $username, $password, $dbname);

$link->set_charset("utf8mb4");

if ($link->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo('connection failed');
}
?>