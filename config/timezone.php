<?php
// session_start();

$timezone = "Asia/Riyadh";

$_SESSION['timezone'] = date_default_timezone_set($timezone);

$when = date("Y-m-d H:i:s");

$dateCancellReservation = date('Y-m-d H:i:s', strtotime('+1 hour'));

 ?>
