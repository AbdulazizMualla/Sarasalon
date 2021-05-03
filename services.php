<?php
$title = 'Services';

require_once 'template/header.php';

$services = $mysqli->query("select * from services s left join
  images_services i on i.service_id = s.id")->fetch_all(MYSQLI_ASSOC);
 ?>
<link rel="stylesheet" href="style.css">

<div class="container pt-5">


<div class="service-area section-padding">
  <div class="container">
    <div class="row text-center">
      <?php foreach ($services as $service):?>
      <div class="col-md-4 col-sm-6 col-xs-12">

        <div class="single-service" >

          <div class="symbol" >
            <img src="<?php echo $service['image'] ?>" alt="" >
          </div>
          <h3><?php echo $service['name'] ; ?></h3>
          <p><?php echo $service['description'] ?></p>

        </div>
        <h6><?php echo $service['price']; ?> SRA</h6>
        <a href="reserving.php?id=<?php echo $service['service_id'] ?>" class="btn btn-info">Go for Reservation</a>

      </div>
   <?php endforeach  ?>
    </div>
  </div>
</div>
<?php $mysqli->close(); ?>
 <?php include 'template/footer.php';
 ?>
