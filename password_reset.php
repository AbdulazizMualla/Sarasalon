<?php
$title = 'Password Reset';
require_once 'template/header.php';

if (isset($_SESSION['logged_in'])) {
      header('location: index.php');
      die();
}
$errors = [];
$email = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($mysqli , $_POST['email']);

    if(empty($email)){array_push($errors,"البريد الإلكتورني مطلوب");}


    if(!count($errors)){

      $userExists = $mysqli->query("select id, email, user_name from users where email='$email' limit 1");

      if($userExists->num_rows){

        $userId = $userExists->fetch_assoc()['id'];

        $tokenExists = $mysqli->query("delete from password_resets where user_id='$userId'");

        $token = bin2hex(random_bytes(16));

        $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));

        $mysqli->query("insert into password_resets (user_id , token , expires_at)
                      values('$userId' , '$token' , '$expires_at')
        ");

        $changePasswordUrl = $config['app_url'].'change_password.php?token='.$token;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

        $headers .= 'From: '.$config['admin_email']."\r\n".
            'Reply-To: '.$config['admin_email']."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $htmlMessage = '<html><body>';
        $htmlMessage .= '<p style="color:#ff0000;">'.$changePasswordUrl.'</p>';
        $htmlMessage .= '</body></html>';

        mail($email , 'Password reset link' , $htmlMessage , $headers);

      }

      $_SESSION['success_message'] = 'تم إرسال رابط تعيين كلمة المرور على بريدك الإلكتروني , قد يستغرق وصول البريد لك مدة خمس دقائق , وقد تجد الرسالة في البريد المزعج';
      header('location: password_reset.php');
      die();
    }

}
?>
<link rel="stylesheet" href="style.css">
<div class="container pt-5">

<div id="password_reset">



  <div class="row" style="display: flex; justify-content: center;">
    <div class="col-lg-6 col-md-12 mb-4 text-right">
      <?php include 'template/errors.php' ?>
      <section>
        <form class=" border border-light p-5" action="" method="post">
          <p class="h1 mb-4 text-center">إعادة تعيين كلمة المرور</p>
            <h6 class="text-info">أدخل بريدك الإلكتروني لإعادة تعيين كلمة المرور الخاصة بك</h6>
          <hr >
            <div class="form-group">
              <input type="email" name="email" class="form-control mb-4" placeholder="البريد الإلكتروني" id="email" value="<?php echo $email ?>">
            </div>


            <div class="form-group">
                <button class="btn btn-info btn-block">أرسل رابط تعيين كلمة المرور!</button>
            </div>
        </form>
      </section>
    </div>
  </div>


</div>
<?php $mysqli->close(); ?>
<?php
include 'template/footer.php';
