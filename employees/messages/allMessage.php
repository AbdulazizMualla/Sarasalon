<?php
$title = 'All Contact';
include __DIR__.'/../template/header.php';

$stmt = $mysqli->query("select * from contactMessage ")->fetch_all(MYSQLI_ASSOC);
?>
<link rel="stylesheet" href="../css/style.css">

<div class="topBage">
  <h2>All Messages</h2>

    <p class="header" >Number of All Messages: <?php echo count($stmt) ?></p>
</div>
<div class="table table-hover table-striped">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Reply</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($stmt as  $st) : ?>

      <tr>
        <td><?php echo $st['contact_name'] ?></td>
        <td><?php echo $st['contact_email'] ?></td>
        <td><?php echo $st['contact_message'] ?></td>
        <td><?php echo $st['reply'] ?></td>
        <td><?php echo $st['created_at'] ?></td>

      </tr>
    <?php endforeach ?>
    </tbody>
  </table>

</div>


<?php $mysqli->close(); ?>
<?php include __DIR__.'/../template/footer.php'; ?>
   <script src="../js/app.js"></script>
