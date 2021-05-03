<?php
$title = 'Contact';
require_once 'template/header.php';


$errors = [];
$name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = filterString($_POST['name']);
        if (!$name){
          $_SESSION['contact_form']['name'] = '';
          array_push($errors ,"Your name is required");
        }else {
          $_SESSION['contact_form']['name'] = $name;
        }

      $email = filterEmail($_POST['email']);
        if (!$email){
          $_SESSION['contact_form']['email'] = '';
          array_push($errors ,"Your email is required");
        }else {
          $_SESSION['contact_form']['email'] = $email;
        }

      $message = filterString($_POST['message']);
        if (!$message){
          $_SESSION['contact_form']['message'] = '';
          array_push($errors ,"Your message is required");
        }else {
            $_SESSION['contact_form']['message'] = $message;
        }

  if (!count($errors) ) {
    $st = $mysqli->prepare("insert into contactMessage (contact_name,contact_email,contact_message,created_at) values(?,?,?,?)");
    $st->bind_param('ssss', $dbContactName ,$dbContactEmail,$dbContactMessage ,$dbCreatedAt );
    $dbContactName = $name;
    $dbContactEmail = $email;
    $dbContactMessage = $message;
    $dbCreatedAt = $when;
    $st->execute();


    /*
    * this action will be snd email to admin
    */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

    $headers .= 'From: '.$email."\r\n".
            'Reply-To: '.$email."\r\n" .
            'X-Mailer: PHP/' . phpversion();
    $htmlMessage = '<html><body>';
    $htmlMessage .= '<p style="color:#ff0000;">'.$message.'</p>';
    $htmlMessage .= '</body></html>';

    if ($st->error) {
        array_push($errors,$st->error);
    }elseif (!mail($config['admin_email'] , 'You have new message' , $htmlMessage , $headers)) {
        array_push($errors,"Error sending your email");
    }else {
        $_SESSION['success_message'] = "The message was sent successfully";
      echo "<script>location.href = 'index.php'</script>";
    }

  }


}
/*
*this function will be filter field email
* parm is post email from form
*/
function filterEmail($field){


    $field = filter_var(trim($field) , FILTER_SANITIZE_EMAIL);

    if(filter_var($field , FILTER_VALIDATE_EMAIL)){

      return $field;
    }else {
      return false;
    }
}
/*
*this function will be filter field text input
* parm is post any text input from form
*/
function filterString($field){

    $field = filter_var(trim($field) , FILTER_SANITIZE_STRING);

    if (empty($field)) {
      return false;
    }else {
      return $field;
    }
}
 ?>




<link rel="stylesheet" href="style.css">
<div class="container pt-5">
<?php include 'template/errors.php' ?>
<div class="row  " style="display: flex; justify-content: center;">
  <div class="col-lg-6 col-md-12 mb-4 ">
    <section>
      <form  class="text-center border border-light p-5" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <p class="h1 mb-4">Contact us</p>
        <hr >
        <div class="form-group">

          <input type="text" name="name" value="<?php echo $name ?>" class="form-control mb-4" placeholder="Name">
        </div>
        <div class="form-group">

          <input type="email" name="email" value="<?php echo $email ?>" class="form-control mb-4" placeholder="E-mail">
        </div>
        <div class="form-group">

          <textarea name="message" rows="10" class="form-control" placeholder="Message"><?php echo $message; ?></textarea>
        </div>
        <button class="btn btn-info btn-block">Send</button>
      </form>
    </section>
  </div>
</div>
<?php $mysqli->close(); ?>
 <?php require_once 'template/footer.php' ?>
