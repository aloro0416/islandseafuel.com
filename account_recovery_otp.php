<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false); }
?>
<?php include_once('layouts/header.php'); 
$error = "";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// PHPMailer Files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $check_email= "SELECT * FROM users WHERE email = '$email'";
    $c_res = $db->query($check_email);
    if (mysqli_num_rows($c_res) > 0) {

        // Generate a random OTP (6-digit number)
        $otp = rand(100000, 999999);

        $dup = "SELECT * FROM recovery WHERE email = '$email' AND status = 1";
        $res = $db->query($dup);
        if (mysqli_num_rows($res) > 0) {
          echo "<script>
              Swal.fire({
                  icon: 'info',
                  title: 'Oops!',
                  text: 'We already sent you an OTP!',
                  confirmButtonText: 'OK'
              });
          </script>";
        } else {
          $ins = "INSERT INTO recovery (email, recovery_key, status) VALUES ('$email','$otp',1)";
          $ress = $db->query($ins);

          //Create an instance; passing `true` enables exceptions
          $mail = new PHPMailer(true);
          try {
              //Server settings
              $mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Username   = 'islandseafuel@gmail.com';              //SMTP username
              $mail->Password   = 'qyba ckrg odib vzso';                  //SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
              $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
              
              //Recipients
              $mail->setFrom('islandseafuel@gmail.com', 'IslandSea');
              $mail->addAddress($email);                                  //Add a recipient
              
              //Content
              $mail->isHTML(true);                                        //Set email format to HTML
              $mail->Subject = 'REQUEST OTP FOR ACCOUNT RECOVERY';
              $mail->Body    =  '
                                <h2>You requested an OTP for account recovery.</h2>
                                <h4>Your OTP is: <strong>' . $otp . '</strong></h4>
                                <p style="margin-top: 100px;">Have a good day!</p>
                                ';
              $mail->send();

              $error = "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP sent!',
                        text: 'We emailed you an OTP!',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        // Show a modal with OTP input field after clicking 'OK'
                        Swal.fire({
                            title: 'Enter OTP to Proceed',
                            text: 'Please enter the OTP sent to your email:',
                            input: 'text',
                            inputPlaceholder: 'Enter OTP',
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            cancelButtonText: 'Cancel',
                            preConfirm: (otp) => {
                                if (!otp) {
                                    Swal.showValidationMessage('OTP is required');
                                    return false;
                                }
                                // Submit the OTP to recovery.php
                                window.location.href = 'recovery_otp.php?otp=' + otp;
                            }
                        });
                    });
                </script>";

          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }

        }

    } else {
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Email doesn\'t exist!',
              confirmButtonText: 'OK'
          });
      </script>";
    }
}
?>

<div class="login-page">
    <div class="text-center">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
        <h4>ISLAND SEA MANAGEMENT SYSTEM</h4>
    </div>
    <?php echo display_msg($msg); ?>
    <?=$error?>
    <form method="post" class="clearfix">
        <div class="form-group">
            <label for="email" class="control-label">Email</label> 
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group text-center">
            <button type="submit" name="send" class="btn btn-danger" style="border-radius:0%">Send OTP for Account Recovery</button>
        </div>
        <div class="text-center">
            <a href="account_recovery_select.php">Back</a>
        </div>
    </form>
</div>

<style>
  body {
    background-image: url('libs/images/bgimg.jpg');
    background-size: cover;
    background-position: center;
  }
  .login-page {
    box-shadow: 2px 2px 5px 2px;
  }
</style>

<?php include_once('layouts/footer.php'); ?>
