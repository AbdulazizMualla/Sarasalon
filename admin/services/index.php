<?php
$title = 'Services';
$icon  = 'cubes';
include __DIR__.'/../template/header.php';
$services = $mysqli->query("select * from images_services i left join services s on
      s.id = i.service_id order by s.id")->fetch_all(MYSQLI_ASSOC);

$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){


    // $statement = $mysqli->prepare("delete i , w , s from images_services i inner join
    // werkdays_services w left join services s on i.service_id = s.id
    // where i.service_id = w.service_id
    // and w.service_id = ? and i.service_id = ? ");
    $statement = $mysqli->prepare("delete from services where id = ? ");
    $statement->bind_param('i' , $serviceId );
    $serviceId = $_POST['service_id'];

    if (!$statement->execute()) {
      array_push($errors, "Cannot delete  a parent row");
    }else {
      if ($_POST['image']) {

        unlink($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'SaraSalon/'.$_POST['image']);
      }
        echo "<script>location.href = 'index.php'</script>";
    }

}
?>
  <div class="card">
    <div class="content">
      <?php include __DIR__.'/../template/errors.php' ?>
      <a href="create.php" class="btn btn-success">Create new services</a>
      <p class="header">Services: <?php echo count($services) ?></p>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
                <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($services as $service) : ?>
              <tr>
                <td><?php echo $service['id'] ?></td>
                <td><?php echo $service['name'] ?></td>
                <td><?php echo $service['description'] ?></td>
                <td><?php echo $service['price'] ?></td>
                <td> <img src="<?php echo $config['app_url'].$service['image']?>" alt="" width="50"> </td>
                <td width="250">
                    <a href="edit.php?id=<?php echo $service['id'] ?>" class="btn btn-warning">Edit</a>
                    <form  method="post" style="display:inline">
                      <input type="hidden" name="service_id" value="<?php echo $service['id'] ?>">
                      <input type="hidden" name="image" value="<?php echo $service['image'] ?>">
                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
