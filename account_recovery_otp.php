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
          $_SESSION['status'] = 'We already sent you an OTP!';
          $_SESSION['status_code'] = 'info';
          header('Location: account_recovery_otp.php');
          exit(0);
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

              $_SESSION['email_success'] = true;
              header('Location: account_recovery_otp.php');
              exit(0);

          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }

        }

    } else {
      $_SESSION['status'] = 'Email doesn\'t exist!';
      $_SESSION['status_code'] = 'error';
      header('Location: account_recovery_otp.php');
      exit(0);
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

<?php
        if (isset($_SESSION['email_success']) && $_SESSION['email_success']) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Show the OTP dialog even if the page is refreshed if it's the first time
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP sent to your email. Please check your inbox.',
                        allowOutsideClick: false,
                        showConfirmButton: true
                    }).then(() => {
                        // Show OTP input dialog after success message
                        Swal.fire({
                            icon: 'info',
                            title: 'Enter OTP',
                            text: 'This is valid for 30 minutes.',
                            input: 'tel',
                            inputPlaceholder: 'Enter OTP',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonText: 'Submit',
                            timer: 1800000,  // 30 minutes timer (30 * 60 * 1000 ms)
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            preConfirm: (token) => {
                                if (!token) {
                                    Swal.showValidationMessage('OTP is required');
                                    return false;
                                }
                                return token;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const token = result.value;
                                window.location.href = `recovery_otp.php?token=${token}`;
                                // Mark that the OTP dialog has been shown by setting the flag
                                localStorage.setItem('otpShown', 'true');
                            }
                        });
                    });
                });
            </script>
            <?php
            unset($_SESSION['email_success']);
        }
     ?>
<style>
  body {
    background-image: url('libs/images/bgi2.jpg');
    background-size: cover;
    background-position: center;
  }
  .login-page {
    box-shadow: 2px 2px 5px 2px;
  }
</style>

<?php include_once('layouts/footer.php'); ?>
