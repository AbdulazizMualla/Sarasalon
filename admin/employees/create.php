<?php
$title = 'Create Employee';
$icon  = 'user';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';


$stGtSerice = $mysqli->query("select * from services ")->fetch_all(MYSQLI_ASSOC);


$errors = [];
$email = '';
$description = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($mysqli , $_POST['email']);
    $description = mysqli_real_escape_string($mysqli , $_POST['description']);

    if(empty($email)){array_push($errors,"Email is require");}
    if(empty($description)){array_push($errors,"Name is require");}
    if(empty($_FILES['image']['name'])){array_push($errors,"Image is require");}


    if (!count($errors)) {

        $stGetInfo = $mysqli->query("select * from users where email = '$_POST[email]' limit 1");

        if ($stGetInfo->num_rows > 0) {


          $date = date('Ym');
          $upload = new Upload('uploads/employees/'.$date);
          $upload->file = $_FILES['image'];
          $errors = $upload->upload();

          if (!count($errors)) {
            $infoUser = $stGetInfo->fetch_assoc();

            $st = $mysqli->prepare("insert into employees (user_id , service_id , name , description , 	image)
                                    values (?,?,?,?,?)");
            $st->bind_param('iisss', $dbUserId , $dbServiceId , $dbName , $dbescription , $dbImage);
            $dbUserId = $infoUser['id'];
            $dbServiceId = $_POST['service'];
            $dbName = $infoUser['user_name'];
            $dbescription = $_POST['description'];
            $dbImage = $upload->filePath;
            $st->execute();

            if (!$st->error) {

                echo "<script>location.href = 'index.php'</script>";

            }else {

              unlink($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'SaraSalon/'.$upload->filePath);
              array_push($errors,"An error occurred, please try again");

            }
          }
        }else {

          array_push($errors,"The employee is not registered as a user");

        }
    }
}

?>
<div class="card">
  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="<?php echo $email ?>">
        </div>


        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" rows="10" cols="30" class="form-control"><?php echo $description ?></textarea>
        </div>


        <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" name="image" value="<?php  ?>">
        </div>


        <div class="form-group">
          <select class="form-control" name="service" id="service">
            <?php foreach ($stGtSerice as $gtSerice) {?>
                <option value="<?php echo $gtSerice['id'] ?>"><?php echo $gtSerice['name'] ?> </option>
              <?php } ?>
          </select>
        </div>



        <div class="form-group">
            <button class="btn btn-success">Create!</button>
        </div>

    </form>
  </div>
</div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
