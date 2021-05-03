<?php
$title = 'Edit service';
$icon  = 'cubes';
include __DIR__.'/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

$statement = $mysqli->prepare("select * from services where id = ? limit 1");
$statement->bind_param('i', $serviceId);
$serviceId = $_GET['id'];
$statement->execute();

$service = $statement->get_result()->fetch_assoc();

$name = $service['name'];
$price = $service['price'];
$description = $service['description'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(empty($_POST['name'])){array_push($errors,"Name is require");}
  if(empty($_POST['price'])){array_push($errors,"Price is require");}
  if(empty($_POST['description'])){array_push($errors,"Description is require");}

  if (!count($errors)) {

    $statement = $mysqli->prepare("update services set name = ? , price = ? , description = ?   where id = ?");
    $statement->bind_param('sdsi' , $dbName, $dbPrice , $dbDescription , $dbId);
    $dbName = $_POST['name'];
    $dbPrice = $_POST['price'];
    $dbDescription = $_POST['description'];
    $dbId = $_GET['id'];

    $statement->execute();

    if($statement->error){
      array_push($errors,$statement->error);
    }else {
      echo "<script>location.href = 'index.php'</script>";
    }
  }
}
?>
<div class="card">
  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>
    <form action="" method="post">


        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control"  id="name" value="<?php echo $name ?>">
        </div>

        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" name="price" class="form-control"  id="price" value="<?php echo $price ?>">
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" rows="10" cols="30" class="form-control"><?php echo $description ?></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-success">Update!</button>
        </div>
    </form>
  </div>
</div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
