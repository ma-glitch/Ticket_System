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
            ';
        } else {
            echo '<li><a href="../pages/login.php">Login</a></li>';
        }
        ?> 
</ul>
    <h1>minside</h1>

    <?php

    $sql = "SELECT Ticket.ticketid, Ticket.kundeid, Ticket.dato, Ticket.beskrivelse, Ticket.status, Ticket.ansattid, Innhold_i_ticket.Innhold
    FROM Ticket
    INNER JOIN Innhold_i_ticket ON Ticket.ticketid = Innhold_i_ticket.ticketid
    INNER JOIN Kunde ON Ticket.kundeid = Kunde.kundeid 
    WHERE Kunde.kundeid = " . $_SESSION['id'] . "";

    $result = $link->query($sql);

    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo '<p>' . $row['ticketid'] . '</p>';
        }
    } else {
        echo '<h1>Fant ingen tickets</h1>';
    }

    ?>
</body>
</html>