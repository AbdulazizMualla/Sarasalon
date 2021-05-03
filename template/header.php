<?php
session_start();
require_once __DIR__.'/../config/app.php' ;
require_once __DIR__.'/../config/database.php' ;
require_once __DIR__.'/../config/timezone.php' ;
error_reporting(E_ALL);
ini_set('display_errors' , 1);

 ?>

<!DOCTYPE html>
<html lang="<?php echo $config['lang'] ?>" dir="<?php echo $config['dir']?>">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width , initial-scale=1.0" >
    <title><?php echo $config['app_name']." | " .$title?></title>





    <link rel="stylesheet" href=" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="template/assets/css/bootstra.min.css">
        <link rel="stylesheet" href="template/style.css">
    </head>
  <body>
    <div class="loader_bg">
      <div class="loader">

      </div>
    </div>
    <div class="">

      <nav class=" navbar navbar-expand-lg navbar-light my-navbar" id="my-navbar">

        <a class="navbar-brand" href="<?php echo $config['app_url'] ?>">
            <img class="logo-navbar" src="images/logSalon.png" alt="<?php echo $config['app_name']; ?>">
         </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo $config['app_url'] ?>"> <i class="fa fa-home"></i> الرئيسية <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="<?php echo $config['app_url'] ?>contact.php"> <i class="fa fa-paper-plane"> </i> تواصل معنا</a>
          </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo $config['app_url'] ?>services.php"> <i class="fa fa-cogs"></i> الخدمات </a>
            </li>
            <?php if (isset($_SESSION['logged_in']) &&  isset($_SESSION['user_role']) && $_SESSION['user_role'] ==  'emp') : ?>
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo $config['app_url']?>employees"> <i class="fa fa-suitcase"></i> العمل</a>
              </li>
            <?php endif ?>
            <?php if (isset($_SESSION['logged_in']) &&  isset($_SESSION['user_role']) && $_SESSION['user_role'] ==  'admin') : ?>
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo $config['app_url']?>admin"> <i class="fa fa-server "></i> لوحة التحكم</a>
              </li>
            <?php endif ?>

        </ul>
        <ul class="navbar-nav mr-auto">
          <?php if(!isset($_SESSION['logged_in'])) :?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $config['app_url'] ?>login.php"> <i class="fa fa-sign-in"></i> تسجيل الدخول</a> </li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $config['app_url'] ?>register.php"> <i class="fa fa-user-plus"></i> التسجيل</a> </li>
        <?php else : ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $config['app_url'] ?>my_reserves.php"> <i class="fa fa-lightbulb-o"></i> حجوزاتي</a> </li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $config['app_url'] ?>logout.php"> <i class="fa fa-sign-out"></i> تسجيل الخروج</a> </li>
        <?php endif ?>
        </ul>

      </div>
      </nav>

    </div>

  <!-- <div class="container pt-5"> -->
  <div class="showMessage">
    <?php include 'message.php' ?>
  </div>
