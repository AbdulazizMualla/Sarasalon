<?php
$title = 'Login';
require_once 'template/header.php';

if (isset($_SESSION['logged_in'])) {
      header('location: index.php');
      die();
}
$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = mysqli_real_escape_string($mysqli , $_POST['email']);
  $password = mysqli_real_escape_string($mysqli , $_POST['password']);
  $captchCode = mysqli_real_escape_string($mysqli , $_POST['captch_code']);
    if(empty($email)){array_push($errors, "البريد الإلكتروني مطلوب");}
    if(empty($password)){array_push($errors, "كلمة المرور مطلوبة");}
    if(empty($captchCode)){
        array_push($errors , 'الكود مطلوب');
    }elseif (!isset($_SESSION['captch_code'])) {
      header('location: login');
      die();
    }elseif($_SESSION['captch_code'] != $captchCode) {
      array_push($errors , 'الكود المدخل غير مطابق مع الكود في الصورة');
    }

      if (!count($errors)) {
        $userExists = $mysqli->query("select * from users where email = '$email' limit 1 ");

        if(!$userExists->num_rows){

          array_push($errors ,  "البريد الإلكتروني , $email غير موجود في سجلاتنا.");
        }else {

           $foundUser = $userExists->fetch_assoc();

          if (password_verify($password , $foundUser['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['user_name'] = $foundUser['user_name'];
            $_SESSION['user_role'] = $foundUser['role'];

            if($foundUser['role'] ==  'admin'){
                header('location: admin');
                die();
            }elseif ($foundUser['role'] ==  'emp') {
              header('location: employees');
              die();
            }else {
              $_SESSION['success_message'] = "Welcome, $foundUser[user_name]";
             // echo "<script>location.href = 'index.php'</script>";
             header('location: index.php');
             die();
            }
          }else {

                  array_push($errors ,"كلمة الرور غير صحيحه");
            }
        }
      }

}
 ?>
 <link rel="stylesheet" href="style.css">
 <div class="container pt-5">

<div id="login">
  <div class="row" style="display: flex; justify-content: center;">
    <div class="col-lg-6 col-md-12 mb-4 text-right">
      <?php include 'template/errors.php' ?>

      <section>
        <form id="frmCap" class="text-center border border-light p-5"  action="" method="post">
          <p class="h1 mb-4">تسجيل الدخول</p>
           <h6 class="text-info">يرجى ملء النموذج أدناه لتسجيل الدخول</h6>
          <hr >
          <div class="form-group">
            <input type="email" name="email" class="form-control  mb-4" placeholder="البريد الإلكتروني" id="email" value="<?php echo $email ?>">
          </div>

          <div class="form-group">
              <input type="password" name="password" class="form-control  mb-4" placeholder="كلمة المرور" id="password">
            </div>

            <div class="form-group">
              <!-- <label for="captch_code">Code</label> -->
              <span class="input-group" style="padding:0">
                <img class="input-group"src="includes/image.php" id="captch_image" alt="">
              </span>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="captch_code" id="captch_code" placeholder="الكود">
            </div>

            <div class="form-group">
                <button class="btn btn-info btn-block" >دخول!</button>
                <a href="password_reset.php">نسيت كلمة المرور؟</a>
            </div>

        </form>
      </section>

    </div>
  </div>

</div>
<!-- <script>
///onclick="submit_data()"
  function submit_data(){
    jQuery.ajax({
      url: 'login.php',
      type: 'post',
      data: jQuery('#frmCap').serialize(),
      success: function(data){
        alert(data);
      }


    });
  }
</script> -->
<?php $mysqli->close(); ?>
 <?php include 'template/footer.php';
 ?>
