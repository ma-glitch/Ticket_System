<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

require_once("../../server/config.php");

mysqli_set_charset($link, 'utf8');

header('Content-Type: text/html; charset=utf-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $navn = $_POST['navn'];
    $beskrivelse = $_POST['beskrivelse'];
    $problem = $_POST['problem'];
    $epost = $_POST['epost'];


    $name_parts = explode(" ", $navn);
    
    $first_name = $name_parts[0]; 
    $last_name =  $name_parts[1];

    $default = 'default';

    if (!isset($_SESSION['id'])) {
        $sql_new_user = "INSERT INTO Kunde (epost, passord, fornavn, etternavn) VALUES (?, ?, ?, ?)";
        $stmt_new_user = $link->prepare($sql_new_user);
        $stmt_new_user->bind_param("ssss", $epost, $default, $first_name, $last_name);

        if ($stmt_new_user->execute()) {
            
            $new_user_id = $link->insert_id;
           
            $_SESSION['id'] = $new_user_id;
        } else {
            echo "Error creating new user: " . $stmt_new_user->error;
            exit;
        }
    }


    
    $sql = "INSERT INTO Ticket (`kundeid`, `beskrivelse`, `ansattid`, `status`, `dato`) 
            VALUES (?, ?, 'nonassigned', 'åpen', NOW())";
    $stmt = $link->prepare($sql);

  
    $stmt->bind_param("ss", $_SESSION['id'], $beskrivelse); 
    if ($stmt->execute()) {
    
        $ticketid = $link->insert_id;

      
        $ticket_innhold = "INSERT INTO `Innhold_i_ticket` (`ticketid`, `Innhold`) VALUES (?, ?)";
        $stmt_innhold = $link->prepare($ticket_innhold);

        $stmt_innhold->bind_param("is", $ticketid, $problem);
        if ($stmt_innhold->execute()) {
            echo "Ticket and content inserted successfully.";
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testdex38@gmail.com';
            $mail->Password = 'cceq qpfw qmlk agyk';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('testdex38@gmail.com');
            $mail->addAddress($epost);
            $mail->isHTML(true);

            $mail->Subject = 'Bekreftelse support ticket: ' . $ticketid;
            $mail-> Body = "Hei, ". $navn . ",<br>
            <br>
            Dette er en bekreftelse på at vi har mottatt din henvendelse vedrørende følgende sak:<br>
            <br>
            Saksnummer: " . $ticketid .  "<br>
            Dato sendt inn: " . date("Y-m-d") . "<br>
            <br>
            Vi ønsker å forsikre deg om at vi tar din henvendelse på alvor, og vårt supportteam vil gjennomgå saken din så raskt som mulig.<br>
            <br>
            For referanseformål, her er en kort oppsummering av din henvendelse:<br>
            <br>
            Beskrivelse av problemet: " . $beskrivelse . "<br>
            <br>
            Vi vil holde deg oppdatert på statusen for saken din. Hvis du har ytterligere spørsmål eller informasjon å legge til, vennligst svar på denne e-posten eller kontakt vårt supportteam direkte.<br>
            <br>
            Takk for din tålmodighet og forståelse.<br>
            <br>
            Vennlig hilsen,<br>
            Ticket syst support team<br>
            Ticket syst";

            $mail->send();

            header("location: ../../index.php");
        } else {
            echo "Error inserting content: " . $stmt_innhold->error;
        }
    } else {
        echo "Error inserting ticket: " . $stmt->error;
    }
}

$link->close(); 


?>