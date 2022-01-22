<?php
  $connection = [
        'host' => 'localhost',
        'username' => 'azooz77758',
        'password' => '11111111',
        'database' => 'dataSalonSara'
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
