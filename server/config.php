<?php
$servername = "localhost";
$username = "root";
$password = "Admin";
$dbname = "ticket_syst";

// koble til databasen
$link = new mysqli($servername, $username, $password, $dbname);

// sjekke om det fungerte
if ($link->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo('connection failed');
}
?>