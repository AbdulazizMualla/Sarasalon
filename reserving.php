<?php
$title = 'Reserving';

require_once 'template/header.php';


if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    die();
}
$dbId = $_GET['id'];
$errors = [];
 $dateNow;

$sttimes = $mysqli->query("select time_service from times_services where service_id = '$dbId'")->fetch_all(MYSQLI_ASSOC);

$stdays = $mysqli->query("select * from werkdays_services where service_id = '$dbId'")->fetch_all(MYSQLI_ASSOC);

$stemps = $mysqli->query("select * from employees where service_id = '$dbId'")->fetch_all(MYSQLI_ASSOC);


// $cancellReservation = date('Y-m-d H:i:s', strtotime('+1 hour'));
if ($_SERVER["REQUEST_METHOD"] == 'POST') {

  $empId = $_POST['empId'];

  $time = $_POST['time'];

  $date = $_POST['day'];

  $dateDay = strtolower(date('l' , strtotime($date)));
          foreach ($stdays as  $stday) {
            if ($stday[$dateDay] == 'yes') {
              $streserv = $mysqli->query("select * from reservations where time = '$time'
                  and date  = '$date' and service_id = $dbId and employee_id = '$empId'  ");
                  if ($streserv->num_rows) {
                      array_push($errors,"Reservation is not available");

                  }else {

                    $strev = $mysqli->prepare("insert into reservations (user_id , service_id ,
                                              employee_id, time, date , day ,	created_at , cancell_reservation) values (?,?,?,?,?,?,?,?)");
                    $strev->bind_param('iiisssss', $dbUserId , $dbServiceId , $dbEmployeeId , $dbTime, $dbDate , $dbDay , $dbCreatedAt, $dbcancellReservation  );
                     $dbUserId = $_SESSION['user_id'];
                     $dbServiceId = $dbId;
                     $dbEmployeeId = $empId;
                     $dbTime = $time;
                     $dbDate = $date;
                     $dbDay = $dateDay;
                     $dbCreatedAt = $when;
                     $dbcancellReservation = $dateCancellReservation;
                     $strev->execute();

                     if (!$strev->error) {
                       $_SESSION['success_message'] = "ok";
                       header('location: my_reserves.php');
                       die();
                     }else {
                       array_push($errors,"Reservation is not done");
                     }
                  }
                ;
            }else {
                array_push($errors,"Reservation is not available");
            }
          }
}




 ?>
 <link rel="stylesheet" href="style.css">
 <div class="container pt-5">

<?php include 'template/errors.php' ?>


<div class="card-deck">
<?php foreach ($stemps as $stemp): ?>

    <div class="card border-info mb-5" style="max-width: 18rem; min-width: 18rem" >

    <div class="card-header">
      <img src="<?php if(isset($stemp['image'])){ echo $stemp['image'];}else {echo "images/1.jpeg"; }?>" alt="images/1.jpeg" class="stafImageShow">
      <span class="text-info "><b><?php echo $stemp['name']?></b> </span></div>

    <div class="card-body text-info">
      <h5 class="card-title">Info</h5>
      <p class="card-text"> <?php echo $stemp['description'] ?> </p>

      <form class="form-group" action="" method="post">
          <input type="hidden" name="empId" value=" <?php echo $stemp['id'] ?> ">
        <select class="text-info border-info" name="day">

          <option value="<?php echo date('Y-m-d'); ?>"><?php echo date('Y-m-d'); ?></option>
          <option value="<?php echo date('Y-m-d',strtotime('+1 day')) ; ?>"><?php echo date('Y-m-d' , strtotime('+1 day')) ; ?></option>

        </select>
          <label for=""></label>
        <select class="text-info border-info" name="time">
          <?php foreach ($sttimes as  $sttime) : ?>
          <option type="time" value="<?php echo  $sttime['time_service']; ?>"><?php echo  $sttime['time_service']; ?></option>
          <?php endforeach ?>
        </select>

        <hr>
          <button class="btn btn-info btn-block">Reserving</button>
      </form>

    </div>
    </div>


<?php endforeach; ?>
  </div>
<?php $mysqli->close(); ?>
<?php require_once 'template/footer.php' ?>
