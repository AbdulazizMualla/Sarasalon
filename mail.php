<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'mailer/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer();


//Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
$mail->isSMTP(true);                                            // Send using SMTP
$mail->Host       = 'localhost';                    // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'support@ssarasalon.com';                     // SMTP username
$mail->Password   = 'Aab@0552662010';                               // SMTP password
$mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above



// Content   mailer
$mail->isHTML(true);                                  // Set email format to HTML
$mail->CharSet = "UTF-8";