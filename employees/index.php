<?php
$title = 'Control Panle';
$icon  = 'control';
include 'template/header.php';


$ste = $mysqli->query("select (select count(*) from contactMessage where reply is null) as count__messages,
                              (select count(*) from reservations where is_pay is null) as count__new_clients,
                              (select count(*) from reservations where is_pay = 'yes' and is_done is null) as count_clients_in_service")->fetch_assoc();

?>
<link rel="stylesheet" href="css/style.css">

<div class="row">
  <div class="col-md-12">
      <h4 class="mt-5 font-weight-bold text-center">Work statistic.</h4>
  </div>
</div>
<hr>
  <div class="row responseItem">
    <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="text-info"><?php echo $ste['count__new_clients']; ?></h3>
                    <span>New Clients</span>
                  </div>
                  <div class="align-self-center">
                    <i class="fa fa-user text-info fa-border fa-3x float-right"></i>
                  </div>
                </div>
                <!-- <div class="progress mt-1 mb-0" style="height: 7px;">
              <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
            </div> -->
              </div>
            </div>

          </div>
        </div>
    <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="text-info"><?php echo $ste['count__messages'] ?></h3>
                    <span>New Messages</span>
                  </div>
                  <div class="align-self-center">
                    <i class="fa fa-envelope text-info fa-border fa-3x float-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="text-info"><?php echo $ste['count_clients_in_service'] ?></h3>
                    <span>Customers in service</span>
                  </div>
                  <div class="align-self-center">
                    <i class="fa fa-cogs text-info fa-border fa-3x float-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
  <?php $mysqli->close(); ?>
<?php include 'template/footer.php'; ?>
<script src="js/app.js"></script>
