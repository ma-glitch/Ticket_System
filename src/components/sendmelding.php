<?php
session_start();
require_once('../../server/config.php');


if (isset($_POST['ticketId'], $_POST['message'])) {
    $ticketId = $_POST['ticketId'];
    $message = $_POST['message'];


    $sql = "INSERT INTO Meldinger_i_sak (ticketid, dato, melding) VALUES ('$ticketId', NOW(), '$message')";
    $stmt = $link->prepare($sql);
    
    if ($stmt->execute()) {
        header("location: ../pages/minside.php");
    } else {
        echo "Error updating ticket status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing parameters.";
}
?>
