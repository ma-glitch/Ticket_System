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


<div class="ticket-wrapp">
           <div class='ticket-width'>
       <?php
       $sql = "SELECT Ticket.ticketid, Ticket.kundeid, Ticket.dato, Ticket.beskrivelse, Ticket.status, Ticket.ansattid, Innhold_i_ticket.Innhold, kunde.epost, kunde.fornavn, kunde.etternavn
       FROM Ticket
       INNER JOIN Innhold_i_ticket ON Ticket.ticketid = Innhold_i_ticket.ticketid
       INNER JOIN Kunde ON Ticket.kundeid = Kunde.kundeid 
       WHERE Kunde.kundeid = " . $_SESSION['id'] . "";
   
       $result = $link->query($sql);
       if ($result->num_rows > 0){
           while ($row = $result->fetch_assoc()){
               echo '<div class="egenticket">';
               echo '<div class="ticket-left">';
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
               echo '<div class"select">
               <form method="post" name="selectform" action="../components/update_status.php">
               <select name="status" id="select-status" onChange="this.form.submit()">
                 <option value="' . $row['status'] .  '">' . $row['status'] . '</option>
                 <option value="Aktiv">Aktiv</option>
                 <option value="Venter på bruker">Venter på bruker</option>
                 <option value="Venter på avdeling">Venter på avdeling</option>
                 <option value="Avsluttet">Avsluttet</option>
               </select>
               <input name="ticketId" type="hidden" value="'. $row['ticketid'] . '"/>
               </form>
               </div>';
               echo '</div>';
               echo '<div class="ticket-content">';
               echo '<h4>Innhold:</h4>';
               echo '<p>' . $row['Innhold'] . '</p>';
               echo '</div>';
               echo '<h4>Ansatt:</h4>';
               echo '<div class"select">
               <form method="post" name="selectform" action="../components/update_ansatt.php">
               <select name="ansatt" id="select-status" onChange="this.form.submit()">
                 <option value="' . $row['ansattid'] .  '">'; 
                 if ($row['ansattid'] == 1) {
                   $sql = "SELECT * FROM Ansatt WHERE ansattid ='" . $row['ansattid'] . "'";
       
                   $resultat = $link->query($sql);
       
                   if ($resultat->num_rows > 0){
                       while ($ansatt = $resultat->fetch_assoc()){
                           echo $ansatt['fornavn'];
                       }
                   }
               } else {
                   echo $row['ansattid'];
               };
           echo '</option>
                 <option value="' . $_SESSION['id'] . '">Set ticket til deg selv</option>
                 <option value="nonassigned">nonasigned</option>
               </select>
               <input name="ticketId" type="hidden" value="'. $row['ticketid'] . '"/>
               </form>
               </div>';
               echo '<div class="ticket-messages">';
               echo '<h4>Meldinger:</h4>';
               echo '</div>';
               echo '</div>';
               echo '<div class="ticket-right">';
                       echo '<h2>Kunde detaljer</h2>';
                       echo '<p>Kunde id: ' . $row['kundeid'] . '</p>';
                       echo '<p>Navn: ' . $row['fornavn'] . ' ' . $row['etternavn'] . '</p>';
                       echo '<p>Epost: ' . $row['epost'] . '</p>';
               echo '</div>';
               echo '</div>';
               
           }
       } else {
           echo '<h1>Fant ingen tickets</h1>';
       };  
       ?>
       </div>
</div>

</body>
</html>