<?php
$title = 'Edit employee';
$icon  = 'user';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}
$stGtSerice = $mysqli->query("select * from services ")->fetch_all(MYSQLI_ASSOC);

$statement = $mysqli->prepare("select * from employees where id = ? limit 1");
$statement->bind_param('i', $empId);
$empId = $_GET['id'];
$statement->execute();

$emp = $statement->get_result()->fetch_assoc();

$description = $emp['description'];
$image = $emp['image'];
$service = $emp['service_id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(empty($_POST['description'])){array_push($errors,"description is require");}

  if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

    $date = date('Ym');
    $upload = new Upload('uploads/employees/'.$date);
    $upload->file = $_FILES['image'];
    $errors = $upload->upload();

    if(!count($errors)){

      unlink($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'SaraSalon/'.$image);
      $image = $upload->filePath;

    }
  }
  if (!count($errors)) {

    $statement = $mysqli->prepare("update employees set service_id = ? , description = ? , image = ?  where id = ?");
    $statement->bind_param('issi' , $dbServiceId, $dbdescription , $dbImage , $dbId);
    $dbdescription = $_POST['description'];
    $dbServiceId = $_POST['service'];
    $dbImage = $image;
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


      <form action="" method="post" enctype="multipart/form-data">



          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="10" cols="30" class="form-control"><?php echo $description ?></textarea>
          </div>


          <div class="form-group">
            <img src="<?php echo $config['app_url'].'/'.$image ?>" width="100" alt="">
            <hr>
          <label for="image">Image:</label>
          <input type="file" name="image" >
          </div>


          <div class="form-group">
            <select class="form-control" name="service" id="service">
              <?php foreach ($stGtSerice as $gtSerice) {?>
                  <option value="<?php echo $gtSerice['id'] ?>" <?php if($service == $gtSerice['id']) echo 'selected' ?>><?php echo $gtSerice['name'] ?> </option>
                <?php } ?>
            </select>
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
