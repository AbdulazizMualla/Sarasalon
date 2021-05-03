
<?php
$title = 'Reception';
include __DIR__.'/../template/header.php';

$statement = $mysqli->query("select r.id , r.time, r.date , r.day , r.is_pay , u.user_name , s.price ,s.name as service_name,
                        e.name as emp_name from reservations r
                        inner join users u on r.user_id = u.id
                        inner join services s on r.service_id = s.id
                        inner join employees e on r.employee_id = e.id where r.is_pay is null  order by r.id")->fetch_all(MYSQLI_ASSOC);


if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $statement = $mysqli->prepare("update reservations set is_pay = ? where id = ?");
  $statement->bind_param('si' , $dbIsPay , $dbId);
  $dbIsPay = 'yes';
  $dbId = $_POST['r_id'];
  $statement->execute();

  if (!$statement->error) {
      echo "<script>location.href = 'reception.php'</script>";
  }
}


?>
<link rel="stylesheet" href="../css/style.css">

<div class="topBage">
  <h2>Reservations</h2>
  <p class="header" >Number of reservations: <?php echo count($statement) ?></p>
   <hr>
   <div class="search">
     <form class="" action="" method="post">
       <label for="idReservation">Id: </label>
       <input type="number" name="idReservation" id="idReservation">
       <button class="btn btn-outline-secondary" type="button" name="button">
          <i class="fa fa-search"></i>
       </button>
     </form>

   </div>
</div>

  <div class="table-responsive">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Customer</th>
          <th>Services</th>
          <th>Price</th>
          <th>Employee</th>
          <th>Day</th>
          <th>Date</th>
          <th>Time</th>
          <th>Actions</th>

        </tr>
      </thead>
      <tbody id="idTbody">
        <?php foreach ($statement as $st) :?>
          <tr>
            <td id="<?php echo $st['id'] ?>"><?php echo $st['id']; ?></td>
            <td><?php echo $st['user_name']; ?></td>
            <td><?php echo $st['service_name']; ?></td>
            <td><?php echo $st['price']; ?> (SAR)</td>
            <td><?php echo $st['emp_name']; ?></td>
            <td><?php echo $st['day']; ?></td>
            <td><?php echo $st['date']; ?></td>
            <td><?php echo $st['time']; ?></td>
            <td>
              <form class="" action="" method="post">
                <input type="hidden" name="r_id" value="<?php echo $st['id'] ?>">
                <button class="btn btn-sm btn-info"type="submit" name="button"><i class="fa fa-check"></i></button>
              </form>
            </td>
          </tr>

        <?php endforeach ?>
      </tbody>
    </table>
  </div>

  <?php $mysqli->close(); ?>
<?php include __DIR__.'/../template/footer.php'; ?>
   <script src="../js/app.js"></script>
