<?php
session_start();
require_once('../../server/config.php');


if (isset($_POST['ticketId'], $_POST['ansatt'])) {
    $ticketId = $_POST['ticketId'];
    $newStatus = $_POST['ansatt'];


    $sql = "UPDATE Ticket SET ansattid = ? WHERE ticketid = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("si", $newStatus, $ticketId);
    
    if ($stmt->execute()) {
        header("location: ../pages/admin.php");
    } else {
        echo "Error updating ticket status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing parameters.";
}
?>
