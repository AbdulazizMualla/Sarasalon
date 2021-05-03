<?php
$title = 'Setting';
$icon  = 'cog';
include __DIR__.'/../template/header.php';
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $appName = mysqli_real_escape_string($mysqli , $_POST['app_name']);
  $adminEmail = mysqli_real_escape_string($mysqli , $_POST['admin_email']);

  if(empty($appName)){array_push($errors,"Application name is require");}
  if(empty($adminEmail)){array_push($errors,"Admin email is require");}

  if(!count($errors)){
    $statement = $mysqli->prepare("update settings set admin_email = ? , app_name = ? where id = 1");
    $statement->bind_param('ss',$dbAdminEmail , $dbAppName);
    $dbAdminEmail = $_POST['admin_email'];
    $dbAppName = $_POST['app_name'];
    $statement->execute();

      echo "<script>location.href = 'index.php'</script>";
  }

}
?>

  <div class="card">

    <div class="content">
      <?php include __DIR__.'/../template/errors.php' ?>

        <h3>Update settings</h3>
        <form class="" action="" method="post">

          <div class="form-group">
            <label for="app_name">Application name</label>
            <input type="text" name="app_name" value="<?php echo $config['app_name'] ?>" id="app_name" class="form-control">
          </div>

          <div class="form-group">
            <label for="admin_email">Admin email</label>
            <input type="email" name="admin_email" value="<?php echo $config['admin_email'] ?>" id="admin_email" class="form-control">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-success">Update settings</button>
          </div>
        </form>

    </div>
  </div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';
