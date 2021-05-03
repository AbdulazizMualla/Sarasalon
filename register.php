<?php
$title = 'Register';
require_once 'template/header.php';

if (isset($_SESSION['logged_in'])) {
      header('location: index.php');
      die();
}
$errors = [];
$email = '';
$name = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($mysqli , $_POST['email']);
    $name = mysqli_real_escape_string($mysqli , $_POST['name']);
    $password = mysqli_real_escape_string($mysqli , $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli , $_POST['password_confirmation']);

    if(empty($email)){array_push($errors,"Email is require");}
    if(empty($name)){array_push($errors,"Name is require");}
    if(empty($password)){array_push($errors,"Password is require");}
    if(!vaildPassword($password)){array_push($errors,"Password must be more than seven characters long and contain at least one upper case letter and one lower case letter");}
    if(empty($password_confirmation)){array_push($errors,"Password confirmation is require");}
    if ($password != $password_confirmation){
      array_push($errors,"Password don't match");
    }

    if(!count($errors)){
      $userExists = $mysqli->query("select id, email from users where email='$email' limit 1");

      if($userExists->num_rows){

          array_push($errors , "Email already registered");
      }
    }
    if (!count($errors)) {

        $password = password_hash($password , PASSWORD_DEFAULT);

        $statement = $mysqli->prepare("insert into users ( email, user_name, password) values(?,?,?)");
        $statement->bind_param('sss' , $email, $name , $password);
        $statement->execute();

        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $mysqli->insert_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['success_message'] = "Welcome to our website, $name";

        header('location: index.php');
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

<div id="register">


  <div class="row" style="display: flex; justify-content: center;">
    <div class="col-lg-6 col-md-12 mb-4">
        <?php include 'template/errors.php' ?>
      <section>
        <form class=" border border-light p-5" action="" method="post">
          <p class="h1 mb-4 text-center">Sign up</p>
            <h6 class="text-info">Please fill in the form below to register a new account</h6>
          <hr >
            <div class="form-group">
              <label for="email">Your Email</label>
              <input type="email" name="email" class="form-control mb-4"  id="email" value="<?php echo $email ?>">
            </div>

            <div class="form-group">
              <label for="name">Your Name</label>
              <input type="text" name="name" class="form-control mb-4"  id="name" value="<?php echo $name ?>">
            </div>

            <div class="form-group">
              <label for="password">Your Password</label>
              <input type="password" name="password" class="form-control mb-4"  id="password">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control mb-4"  id="password_confirmation">
            </div>

            <div class="form-group">
                <button class="btn btn-info btn-block">Sign in</button>

            </div>
            <div class="form-group">
                  <a href="login.php">Already have an account? login here</a>
            </div>
        </form>
      </section>
    </div>
  </div>


</div>
<?php $mysqli->close(); ?>
<?php
include 'template/footer.php';
