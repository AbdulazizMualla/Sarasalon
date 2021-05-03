<?php
$title = 'Reply';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

require_once __DIR__.'/../template/header.php';

$id = $_GET['id'];
$statement = $mysqli->query("select * from contactMessage where id = $id limit 1")->fetch_assoc();



$errors = [];
$email = $statement['contact_email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $reply = filterString($_POST['reply_message']);
    if (!$reply){
      array_push($errors ,"Your name is required");
    }

    if (!count($errors)) {
      $st = $mysqli->prepare("update contactMessage set reply = ? where id = ?");
      $st->bind_param('si' , $dbReply , $dbId);
      $dbReply = $_POST['reply_message'];
      $dbId = $id;
      $st->execute();


      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

      $headers .= 'From: '.$config['admin_email']."\r\n".
              'Reply-To: '.$config['admin_email']."\r\n" .
              'X-Mailer: PHP/' . phpversion();
      $htmlMessage = '<html><body>';
      $htmlMessage .= '<p style="color:#ff0000;">'.$reply.'</p>';
      $htmlMessage .= '</body></html>';

      if ($st->error) {
        array_push($errors ,$st->error);
      }elseif (!mail($email , 'You have new message' , $htmlMessage , $headers)) {
          array_push($errors,"Error sending your email");
      }else {
        echo "<script>location.href = 'index.php'</script>";
      }
    }
}

function filterString($field){

    $field = filter_var(trim($field) , FILTER_SANITIZE_STRING);

    if (empty($field)) {
      return false;
    }else {
      return $field;
    }
}
 ?>
 <link rel="stylesheet" href="../css/style.css">
 <div class="card">

   <div class="content">

     <?php include __DIR__.'/../template/errors.php' ?>

     <form style="padding: 20px"action="" method="post">

       <div class="form-group">
         <label for="name">Name:</label>
         <input type="text" name="name" class="form-control" id="name" value="<?php echo $statement['contact_name'] ?>" readonly>
       </div>

       <div class="form-group">
         <label for="email">Email:</label>
         <input type="email" name="email" class="form-control" id="email" value="<?php echo $statement['contact_email'] ?>" readonly>
       </div>

       <div class="form-group">
         <label for="date">Date & Time:</label>
         <input type="datetime" name="date" class="form-control" id="date" value="<?php echo $statement['created_at'] ?>" readonly>
       </div>

       <div class="form-group">
         <label for="message">Message:</label>
        <textarea name="message" class="form-control" rows="4" cols="80" readonly><?php echo $statement['contact_message'] ?></textarea>
       </div>

       <div class="form-group">
         <label for="reply_message">Reply:</label>
        <textarea name="reply_message" class="form-control" rows="4" cols="80" ></textarea>
       </div>
       <div class="form-group">
         <button class="btn btn-sm btn-info" type="submit" name="button"><i class="fa fa-paper-plane mr-1"></i>Send</button>
       </div>
     </form>
   </div>
 </div>

 <?php $mysqli->close(); ?>
 <?php include __DIR__.'/../template/footer.php' ?>
 <script src="../js/app.js"></script>
