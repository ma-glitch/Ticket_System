<?php
session_start();
 require_once('../../server/config.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mine tickets</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<ul>
        <li><a href="../../index.php">Hjem</a></li>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '
            <li><a href="../components/logut.php">Log ut</a></li>
            <li><a href="../pages/minside.php">Mine Tickets</a></li>
            <li><a href="../pages/admin.php">Admin</a></li>';
        } else {
            echo '<li><a href="../pages/login.php">Login</a></li>';
        }
        ?> 
</ul>
    <h1>minside</h1>
    <div class="ticket-wrapp">
        <div class='ticket-width'>
    <?php
    $sql = "SELECT Ticket.ticketid, Ticket.kundeid, Ticket.dato, Ticket.beskrivelse, Ticket.status, Ticket.ansattid, Innhold_i_ticket.Innhold
    FROM Ticket
    INNER JOIN Innhold_i_ticket ON Ticket.ticketid = Innhold_i_ticket.ticketid
    INNER JOIN Kunde ON Ticket.kundeid = Kunde.kundeid 
    WHERE Kunde.kundeid = " . $_SESSION['id'] . "";

    $result = $link->query($sql);
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo '<div class="egenticket">';
            echo '<div class="ticket-header">';
            echo '<h3>Ticket Nummmer: ' . $row['ticketid'] . '</h3>';
            echo '<p>Date: ' . $row['dato'] . '</p>';
            echo '</div>';
            echo '<div class="ticket-details">';
            echo '<h4>Kort beskrivelse:</h4>';
            echo '<p>' . $row['beskrivelse'] . '</p>';
            echo '</div>';
            echo '<div class="ticket-status">';
            echo '<h4>Status:</h4>';
            echo '<p>' . $row['status'] . '</p>';
            echo '</div>';
            echo '<div class="ticket-content">';
            echo '<h4>Innhold:</h4>';
            echo '<p>' . $row['Innhold'] . '</p>';
            echo '</div>';
            echo '<div class="ticket-messages">';
            echo '<h4>Messages:</h4>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<h1>Fant ingen tickets</h1>';
    }
    ?>
    </div>
    </div>
</body>
</html>