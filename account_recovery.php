<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false);}
?>
<?php include_once('layouts/header.php'); 
$error = "";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $check_email= "SELECT * FROM users WHERE email = '$email'";
    $c_res = $db->query($check_email);
    if (mysqli_num_rows($c_res) > 0) {

        $randomKey = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYX", 5)), 0, 8);

         // PHPMailer Files
         require 'PHPMailer/src/Exception.php';
         require 'PHPMailer/src/PHPMailer.php';
         require 'PHPMailer/src/SMTP.php';

        $dup = "SELECT * FROM recovery WHERE email = '$email' AND status = 1";
        $res = $db->query($dup);
        if (mysqli_num_rows($res) > 0) {
            $error = "<center><span class='text-center badge bg-info' style='padding: 8px;'>We already sent you a recovery link!</span></center>";
        }else{
          $ins = "INSERT INTO recovery (email, recovery_key, status) VALUES ('$email','$randomKey',1)";
          $ress = $db->query($ins);

           //Create an instance; passing `true` enables exceptions
          $mail = new PHPMailer(true);
          try {
              //Server settings
              $mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Username   = 'islandsea2001@gmail.com';            //SMTP username
              $mail->Password   = 'bkggsnzgpxrzrovb';                     //SMTP password
              $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
              $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
              //Recipients
              $mail->setFrom('islandsea2001@gmail.com', 'IslandSea');
              $mail->addAddress($email);                                  //Add a recipient
              //Content
              $mail->isHTML(true);                                        //Set email format to HTML
              $mail->Subject = 'REQUEST RECOVERY LINK';
              $mail->Body    =  '
                                <h2>You request an account recovery link from our system.</h2>
                                <h4>Here\'s your <a href="https://islandseafuel.com/recovery.php?email='.$email.'&key='.$randomKey.'" style="background: green; color: white; width: 100%; padding: 10px; border-radius: 10px; text-decoration: none;">Recovery Link!</a></h4>
                                <p style="margin-top: 100px;">Have a good day!</p>
                                ';
              $mail->send();

              $error = "<center><span class='text-center badge' style='padding: 8px; background: gold;'>Recovery link sent!</span></center>";


          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }

          }

    }else{
        $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Email doesn't exist!</span></center>";
    }
}



?>
<div class="login-page">
    <div class="text-center">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
       <h4>ISLAND SEA MANAGEMENT SYSTEMS </h4>
     </div>
     <?php echo display_msg($msg); ?>
     <?=$error?>
      <form method="post" class="clearfix">
        <div class="form-group">
              <label for="email" class="control-label">Email</label> 
              <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group text-center">
                <button type="submit" name="send" class="btn btn-danger" style="border-radius:0%">Send Account Recovery Link</button>
        </div>
        <div class="text-center">
            <a href=".">Back</a>
        </div>
    </form>
</div>

<style>
  body{
    background-image: url('libs/images/bgimg.jpg');
    background-size: cover;
    background-position: center;
  }
  .login-page{
    box-shadow: 2px 2px 5px 2px;
  }
</style>

<?php include_once('layouts/footer.php'); ?>
