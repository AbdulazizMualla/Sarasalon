<?php
session_start();
require_once __DIR__.'/../../config/app.php';
require_once __DIR__.'/../../config/database.php';
require_once __DIR__.'/../../config/timezone.php';
require_once __DIR__.'/../../classes/User.php' ;
error_reporting(E_ALL);
ini_set('display_errors' , 1);

$user = new User;
if (!$user->isEmp()) {
  if (!$user->isAdmin()) {
      die('You are not allowed to access this page');
  }
}
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width-device-width , initial-scale=1.0" >
     <title><?php echo $config['app_name'].' | '.$title; ?></title>


         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">





   </head>
   <body>

     <div class="wrapper d-flex align-items-stretch">
       	<?php include 'sidebar.php' ?>


         <!-- Page Content  -->
       <div id="content" class="p-4 p-md-5 pt-5">
         <div class="container-fluid">
