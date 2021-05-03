<?php
$title = 'Home Page';
require_once 'template/header.php';

$services = $mysqli->query("select * from services s  left join
  images_services i on i.service_id = s.id limit 3")->fetch_all(MYSQLI_ASSOC);

 ?>
 <link rel="stylesheet" href="style.css">

<div class="homePage">
  <div class="HomeScreenPhrases">
    <div class="container text-center">
      <h1  style="font-size:3vw;"></h1>
        <h1></h1>
    </div>

  </div>

</div>
<hr>
<div class="container pt-5">

<section class="slideshow">
  <div class="content">
    <div class="content-carrousel">
      <figure class="shadow">
        <img src="images/13.jpeg" alt="">
      </figure>
      <figure class="shadow">
        <img src="images/14.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/mec4.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/herS.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/herK.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/mec2.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/mec3.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/mec5.jpeg" alt="">
      </figure>
      <figure class="coustomShadow">
        <img src="images/mec6.jpeg" alt="">
      </figure>

    </div>

  </div>

</section>
<hr>

  <div class="container text-center">
    <h2 class="text-muted">خدماتنا</h2>
    <div class="row">
      <?php foreach ($services as $service):?>
      <div class="col-md-4 col-sm-6 col-xs-12">

        <div class="single-service shadow" >

          <div class="symbol" >
            <img src="<?php echo $service['image'] ?>" alt="" >
          </div>
          <h3><?php echo $service['name'] ; ?></h3>
          <p><?php echo $service['description'] ?></p>

        </div>

      </div>
   <?php endforeach  ?>
    </div>
      <a href="services.php" class="btn btn-outline-info">تصفح المزيد...</a>
  </div>
<hr>
<div class="container text-center">
  <p>إذا كانت لديك أية شكاوى أو اقتراحات ، نرجو منك كتابتها <a href="contact.php" class="">هنا</a> وسيقوم فريقنا بالرد عليك</p>
</div>

 <script>

 </script>
<?php $mysqli->close(); ?>
<?php require_once 'template/footer.php' ?>
