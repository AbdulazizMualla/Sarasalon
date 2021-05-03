<?php
$title = 'My Reserves';
require_once 'template/header.php';


if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    die();
}
$errors = [];
$cancelAvailable = [];
$userId = $_SESSION['user_id'];



 $stmts = $mysqli->prepare("select * , s.id as service_id ,s.name as service_name ,
                            e.id as emp_id, e.name as emp_name , r.id as r_id
                            from services s  join reservations r on r.service_id = s.id
                              join employees e on  r.employee_id = e.id
                               where r.user_id = ?");

$stmts->bind_param('i' , $userId);
$stmts->execute();


$res = $stmts->get_result()->fetch_all(MYSQLI_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

for ($i=0; $i < count($res) ; $i++) {

    if ($_POST['reserves_id'] == $res[$i]['r_id']) {

      if (date('Y-m-d H:i:s') < $res[$i]['cancell_reservation']) {

        $statement = $mysqli->prepare("delete from reservations where id = ?");
        $statement->bind_param('i' , $dbId);
        $dbId = $_POST['reserves_id'];
        $statement->execute();

        if ($statement->error) {
            array_push($errors,$statement->error);
        }else {
            header('location: my_reserves.php');
            die();
        }
      }
    }
  }
}

 ?>
 <link rel="stylesheet" href="style.css">
 <div class="container pt-5">

   <?php include 'template/errors.php' ?>
   <?php if($res): ?>
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <h4 class="alert-heading">Attention!</h4>
   <p>You can cancel a reservation that is less than an hour before the execution date of the reservation.</p>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
 </button>
 </div>
<?php elseif (!$res) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <p class="text-center">You don't have reservations.</p>
  </div>
<?php endif ?>
<div class="card-deck">
   <?php foreach ($res as $re): ?>
  <div class="card border-info mb-5" style="max-width: 18rem; min-width: 18rem">
    <div class="card-header">
      <span class="text-info "><b>Reservation card</b> </span>
    </div>
    <div class="card-body text-dark">
      <p class="card-text"> id: <?php echo $re['r_id'] ?> </p>
      <hr>
      <p class="card-text">Services: <?php echo $re['service_name'] ?> </p>
      <hr>
      <p class="card-text">Employee: <?php echo $re['emp_name'] ?> </p>
      <hr>
      <p class="card-text">Day: <?php echo $re['day'] ?> </p>
      <hr>
      <p class="card-text">Date: <?php echo $re['date'] ?> </p>
      <hr>
      <p class="card-text">Time: <?php echo $re['time'] ?> </p>
      <hr>
      <?php if (date('Y-m-d H:i:s') < $re['cancell_reservation']) :

          array_push($cancelAvailable,$re['r_id']);

         ?>

        <form class="" action="" method="post">
          <input type="hidden" name="reserves_id" value="<?php echo $re['r_id']; ?>">
          <button class="btn btn-info btn-block">Cancel</button>
        </form>
      <?php endif ?>

    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php $mysqli->close(); ?>

<?php require_once 'template/footer.php' ?>
