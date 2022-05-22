<?php
  $connection = [
        'host' => 'localhost',
        'username' => '',
        'password' => '',
        'database' => ''
  ];

  $mysqli = new mysqli(
    $connection['host'] ,
    $connection['username'],
    $connection['password'],
    $connection['database']
  );

  if ($mysqli-> connect_error) {
      die("Error connecting to database".$mysqli->connect_error);
  }
