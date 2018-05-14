<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  session_start();

  require_once('db.php');
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim(preg_replace("/\t|\R/",' ', $_POST['email']));
    $result = $mysqli->query("SELECT * FROM ACCOUNT WHERE email='$email'");

    if($result->num_rows == 0) // User doesn't exist
    {
      $_SESSION['message'] = "User with that email doesn't exist";
      header("location: error.php");
    }
    else{
      $user = $result->fetch_assoc(); //get user data

      $hash = $user['hash'];
      $email = $user['email'];
      $first_name = $user['first_name'];

      //Session message
      $_SESSION['message'] = "<p>
      Please check your email <span>$email</span>"
      ."for a confirmation link to complete your password reset</p>";

      //Load Composer's autoloader
      require 'vendor/autoload.php';

      $mail = new PHPMailer();
      $mail->CharSet =  "utf-8";
      $mail->IsSMTP(); // Set mailer to use SMTP
      $mail->SMTPDebug = 1;  // Enable verbose debug output
      $mail->SMTPAuth = true; // Enable SMTP authentication
      $mail->Username = "npkteam714@gmail.com"; //Your Auth Email ID
      $mail->Password = "npkteam123"; //Your Password
      $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
      $mail->Host = "smtp.gmail.com"; // SMTP
      $mail->Port = "587"; // TCP port to connect to

      $mail->setFrom('zindara2412@gmail.com', 'NPK Basketball Team Management');
      $mail->AddAddress("$email" , "Recipient name"); // Add a recipient

      $mail->addAttachment('path/file.png');         // Add attachments

      $mail->Subject = "Password Reset - NPK Basketball Team Management";
      $mail->Body = "Please click the link to reset your account:
      http://localhost/csufbasketballteam/reset.php?email=$email&hash=$hash";
      $mail->ContentType = "text/html";

      if($mail->Send()){
       $str = "OK";
      }else{
       $str = "ERR";
      }


        header("location: success.php");
    }
  }

?>

 <!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>

  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="ForgotPassword.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
