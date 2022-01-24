<?php
$title = 'Edit user';
$icon  = 'users';
include __DIR__.'/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

$statement = $mysqli->prepare("select * from users where id = ? limit 1");
$statement->bind_param('i', $userId);
$userId = $_GET['id'];
$statement->execute();

$user = $statement->get_result()->fetch_assoc();

$name = $user['user_name'];
$email = $user['email'];
$role = $user['role'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(empty($_POST['email'])){array_push($errors,"Email is require");}
  if(empty($_POST['name'])){array_push($errors,"Name is require");}
  if(empty($_POST['role'])){array_push($errors,"Role is require");}

  if (!count($errors)) {

    $statement = $mysqli->prepare("update users set user_name = ? , email = ? , role = ? , password = ?  where id = ?");
    $statement->bind_param('ssssi' , $dbName, $dbEmail , $dbRole, $dbPassword , $dbId);
    $dbName = $_POST['name'];
    $dbEmail = $_POST['email'];
    $dbRole = $_POST['role'];
    $_POST['password'] ? $dbPassword = password_hash($_POST['password'],PASSWORD_DEFAULT) : $dbPassword = $user['password'];
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
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="<?php echo $email ?>">
        </div>

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Name" id="name" value="<?php echo $name ?>">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password" id="password">
        </div>
        <div class="form-group">
          <label for="role">Role:</label>
          <select class="form-control" name="role" id="role">
            <option value="user" <?php if($role == 'user') echo 'selected' ?>>User</option>
            <option value="admin" <?php if($role == 'admin') echo 'selected' ?>>Admin</option>
              <option value="emp" <?php if($role == 'emp') echo 'selected' ?>>employee</option>
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
