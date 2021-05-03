<?php
require_once 'mail.php';
$mail->setFrom('support@ssarasalon.com', 'Tawfeg Tame');
$mail->addAddress('amgad74@hotmail.com');

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();