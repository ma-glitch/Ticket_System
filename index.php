<?php
session_start();
 require_once('server/config.php'); 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/src/styles/style.css">
    <title>Ticket system</title>
</head>
<body>
    <ul>
        <li><a href="index.php">Hjem</a></li>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '
            <li><a href="src/components/logut.php">Log ut</a></li>
            <li><a href="src/pages/minside.php">Mine Tickets</a></li>
            ';
        } else {
            echo '<li><a href="src/pages/login.php">Login</a></li>';
        }
        ?> 
    </ul>
    <h1 class="header">Support ticket</h1>
<div class="ticket-wrapper">
    <div class="ticket-form">
        <h2>Send Ticket</h2>
        <form action="/src/components/ticket.php" method="post">
            <label for="name">Fullt Navn:</label>
            <input type="text" id="name" name="navn" required>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                echo '<input type="hidden" name="epost" value="' . $_SESSION['epost'] . '">';               
                
            } else{
                echo '<label for="epost">Epost:</label>
                      <input type="text" id="epost" name="epost" required>';
            }
            ?>
            
            <label for="description">Kort beskrivelse:</label>
            <input type="text" id="description" name="beskrivelse" required>
            
            <label for="request">Problem:</label>
            <textarea id="request" name="problem" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>
</body>
</html>