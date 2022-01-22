<?php
include_once 'database.php';

$settings = $mysqli->query("select * from settings where id = 1")->fetch_assoc();

if (count($settings)) {
  $app_name = $settings['app_name'];
  $admin_email = $settings['admin_email'];
}else {
  $app_name = 'Sara Salon';
  $admin_email = 'amgad74@hotmail.com';
}

  $config = [
    'app_name' =>  $app_name,
    'admin_email' => $admin_email,
    'lang' => 'ar',
    'dir' => 'rtl',
    'app_url' => 'https://sarasalone.tawfig.info/',
    'admin_assets' => 'https://sarasalone.tawfig.info/admin/template/BS3/assets'

  ];




 ?>
