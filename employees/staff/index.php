<?php
$title = 'Reception';
include __DIR__.'/../template/header.php';
$staffId = $_SESSION['user_id'];

$statement = $mysqli->query("select r.*, u.user_name , s.name as service_name  , e.user_id  from reservations r
                              inner join users u on r.user_id = u.id
                              inner join services s on r.service_id = s.id
                              inner join employees e on r.employee_id = e.id
                              where r.is_pay = 'yes' and
                              r.is_done is null and
                              e.user_id = $staffId
                              order by r.time")->fetch_all(MYSQLI_ASSOC);


if($_SERVER['REQUEST_METHOD'] == 'POST'){


$statement = $mysqli->prepare("update reservations set is_done = ? where id = ?");
$statement->bind_param('si' , $dbIsDone , $dbId);
$dbIsDone = 'yes';
$dbId = $_POST['r_id'];
$statement->execute();

  if (!$statement->error) {
    echo "<script>location.href = 'index.php'</script>";
    }
}
?>
<link rel="stylesheet" href="../css/style.css">
<div class="topBage">
  <h2>Reservations</h2>
  <p class="header" >Number of reservations: <?php echo count($statement) ?></p>

</div>
<div class="table-responsive">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Customer</th>
        <th>Services</th>
        <th>Time</th>
        <th>Actions</th>

      </tr>
    </thead>
    <tbody id="idTbody">
      <?php foreach ($statement as $st) :?>
        <tr>
          <td><?php echo $st['user_name']; ?></td>
          <td><?php echo $st['service_name']; ?></td>
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
