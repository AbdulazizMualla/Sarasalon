<?php
$title = 'Contact';
include __DIR__.'/../template/header.php';

$ste = $mysqli->query("select * from contactMessage where reply is null")->fetch_all(MYSQLI_ASSOC);

?>
<link rel="stylesheet" href="../css/style.css">

<div class="topBage">
  <h2>Messages</h2>

    <p class="header" >Number of new Messages: <?php echo count($ste) ?></p>
    <a href="allMessage.php" class="btn btn-info mb-4">Show all Messages</a>




</div>
<div class="table table-hover table-striped">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ste as  $st) : ?>

      <tr>
        <td><?php echo $st['contact_name'] ?></td>
        <td><?php echo $st['contact_email'] ?></td>
        <td><?php echo $st['created_at'] ?></td>
        <td>
          <a href="reply.php?id=<?php echo $st['id'] ?>" class="btn btn-sm btn-info fa fa-envelope-open"></a>
        </td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>

</div>
<?php $mysqli->close(); ?>
<?php include __DIR__.'/../template/footer.php'; ?>
   <script src="../js/app.js"></script>
