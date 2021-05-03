<?php
$title = 'Change Password';
require_once 'template/header.php';

if (isset($_SESSION['logged_in'])) {
      header('location: index.php');
      die();
}

if (!isset($_GET['token']) || !$_GET['token']) {
  die('Token parameter is missing');
}

$now = date('Y-m-d H:i:s');

$stmt = $mysqli->prepare("select * from password_resets where token = ? and expires_at > '$now'");
$stmt->bind_param('s' , $token);
$token = $_GET['token'];
$stmt->execute();
$result = $stmt->get_result();

if (!$result->num_rows) {
    die('Token is not valid');
}


$errors = [];



if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $password = mysqli_real_escape_string($mysqli , $_POST['password']);
  $password_confirmation = mysqli_real_escape_string($mysqli , $_POST['password_confirmation']);
  
  if(!vaildPassword($password)){array_push($errors,"Password must be more than seven characters long and contain at least one upper case letter and one lower case letter");}
  if(empty($password)){array_push($errors,"Password is require");}
  if(empty($password_confirmation)){array_push($errors,"Password confirmation is require");}
  if ($password != $password_confirmation){
    array_push($errors,"Password don't match");
  }


    if(!count($errors)){

      $hashed_password = password_hash($password , PASSWORD_DEFAULT);
      $userId = $result->fetch_assoc()['user_id'];


      $mysqli->query("update users set password = '$hashed_password' where id = '$userId'");


      $mysqli->query("delete from password_resets where user_id = '$userId'");

      $_SESSION['success_message'] = 'Your password has been changed, Please log in';

      header('location: login.php');
      die();
    }

}

function vaildPassword($password){
  $upper = false;
  $lower = false;
  if (strlen($password) >= 8) {
      for ($i=0; $i < strlen($password) ; $i++) {
        $pass = $password[$i];
            if (ctype_upper($pass) ) {
              $upper = true;
            }
            if (ctype_lower($pass)) {
              $lower = true;
            }
      }
      if ($upper && $lower ) {
        return true;
      }
  }
  return false;
}
?>
<link rel="stylesheet" href="style.css">
<div class="container pt-5">

<div id="password_reset">

  <h4></h4>

  <hr>
  <?php include 'template/errors.php' ?>
  <div class="row" style="display: flex; justify-content: center;">
    <div class="col-lg-6 col-md-12 mb-4">
      <section>
        <form class="border border-light p-5" action="" method="post">
          <p class="h1 mb-4 text-center">Create new Password</p>
            <div class="form-group">
              <input type="password" name="password" class="form-control mb-4" placeholder="New password" id="password">
            </div>
            <div class="form-group">
              <input type="password" name="password_confirmation" class="form-control mb-4" placeholder="confirm password" id="password_confirmation" >
            </div>


            <div class="form-group">
                <button class="btn btn-info btn-block">Change password!</button>
            </div>
        </form>
      </section>

    </div>
  </div>


</div>
<?php $mysqli->close(); ?>
<?php
include 'template/footer.php';
