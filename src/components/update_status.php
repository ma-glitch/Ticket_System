<?php
session_start();
require_once('../../server/config.php');


if (isset($_POST['ticketId'], $_POST['status'])) {
    $ticketId = $_POST['ticketId'];
    $newStatus = $_POST['status'];


    $sql = "UPDATE Ticket SET status = ? WHERE ticketid = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("si", $newStatus, $ticketId);
    
    if ($stmt->execute()) {
        echo "Ticket status updated successfully.";
    } else {
        echo "Error updating ticket status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing parameters.";
}
?>
