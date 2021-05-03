<?php
$title = 'Create user';
$icon  = 'users';
include __DIR__.'/../template/header.php';



$errors = [];
$email = '';
$name = '';
$role = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($mysqli , $_POST['email']);
    $name = mysqli_real_escape_string($mysqli , $_POST['name']);
    $password = mysqli_real_escape_string($mysqli , $_POST['password']);
    $role = mysqli_real_escape_string($mysqli , $_POST['role']);

    if(empty($email)){array_push($errors,"Email is require");}
    if(empty($name)){array_push($errors,"Name is require");}
    if(empty($password)){array_push($errors,"Password is require");}
    if(empty($role)){array_push($errors,"Role is require");}



    if (!count($errors)) {

        $password = password_hash($password , PASSWORD_DEFAULT);

        $statement = $mysqli->prepare("insert into users ( email, user_name, password, role) values(?,?,?,?)");
        if ($statement == false) {
          array_push($errors, "query is not m");
        }else {
          $statement->bind_param('ssss' , $email, $name , $password , $role);
          $statement->execute();
          if ($statement->error) {
              array_push($errors, $statement->error);
          }else {
            echo "<script>location.href = 'index.php'</script>";
          }
        }




        // $query = "insert into users ( email, name, password, role) values('$email','$name','$password','$role')";
        // $mysqli->query($query);
        //
        // if ($mysqli->error) {
        //     array_push($errors, $mysqli->error);
        // }else {
        //   echo "<script>location.href = 'index.php'</script>";
        // }


    }
}
?>
<div class="card">
  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>
    <form action="" method="post">

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="">
        </div>

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Name" id="name" value="">
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
            <button class="btn btn-success">Create!</button>
        </div>
    </form>
  </div>
</div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
<!-- <?php echo $name ?> -->
