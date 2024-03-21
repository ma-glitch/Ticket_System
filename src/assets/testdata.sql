-- Test data for Kunde table
INSERT INTO `Kunde` (`epost`, `passord`, `fornavn`, `etternavn`) VALUES
('kunde1@example.com', 'password1', 'John', 'Doe'),
('kunde2@example.com', 'password2', 'Jane', 'Smith'),
('kunde3@example.com', 'password3', 'Alice', 'Johnson');

-- Test data for Ansatt table
INSERT INTO `Ansatt` (`fornavn`, `etternavn`, `epost`, `passord`) VALUES
('Mark', 'Anderson', 'mark@example.com', 'password1'),
('Emily', 'Brown', 'emily@example.com', 'password2'),
('David', 'Clark', 'david@example.com', 'password3');

-- Test data for Ticket table
INSERT INTO `Ticket` (`kundeid`, `beskrivelse`, `ansattid`, `status`, `dato`) VALUES
(1, 'Printer not working', 1, 'Open', UNIX_TIMESTAMP()),
(2, 'Cant access email', 2, 'Open', UNIX_TIMESTAMP()),
(3, 'Software installation issue', 3, 'Open', UNIX_TIMESTAMP());

-- Test data for Innhold_i_ticket table
INSERT INTO `Innhold_i_ticket` (`ticketid`, `Innhold`) VALUES
(1, 'Tried restarting the printer but issue persists.'),
(2, 'Checked email settings but still unable to access.'),
(3, 'Received error message "Installation failed. Contact support."');

-- Test data for Meldinger_i_sak table
INSERT INTO `Meldinger_i_sak` (`ticketid`, `dato`, `melding`) VALUES
(1, NOW(), 'We will dispatch a technician to your location.'),
(2, NOW(), 'We are investigating the issue and will update you shortly.'),
(3, NOW(), 'Our team is working on resolving the installation problem.');
