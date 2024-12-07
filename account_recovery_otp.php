<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false); }
?>
<?php include_once('layouts/header.php'); 
$error = "";

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $c_res = $db->query($check_email);
    
    if (mysqli_num_rows($c_res) > 0) {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // PHPMailer Files
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        // Check if OTP has been already sent to this email
        $dup = "SELECT * FROM recovery WHERE email = '$email' AND status = 1";
        $res = $db->query($dup);
        
        if (mysqli_num_rows($res) > 0) {
            $error = "<center><span class='text-center badge bg-info' style='padding: 8px;'>We already sent you an OTP!</span></center>";
        } else {
            // Insert OTP into the recovery table with status 1 (active)
            $ins = "INSERT INTO recovery (email, recovery_key, status) VALUES ('$email','$otp',1)";
            $ress = $db->query($ins);

            // Create an instance of PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'islandsea2001@gmail.com';              // SMTP username
                $mail->Password   = 'bkggsnzgpxrzrovb';                     // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable implicit TLS encryption
                $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                // Recipients
                $mail->setFrom('islandsea2001@gmail.com', 'IslandSea');
                $mail->addAddress($email);                                   // Add a recipient
                
                // Content
                $mail->isHTML(true);                                         // Set email format to HTML
                $mail->Subject = 'Your OTP for Account Recovery';
                $mail->Body    =  '
                                    <h2>You requested an account recovery OTP.</h2>
                                    <h4>Your OTP is: <b>' . $otp . '</b></h4>
                                    <p style="margin-top: 100px;">Have a good day!</p>
                                    ';
                $mail->send();

                $error = "<center><span class='text-center badge' style='padding: 8px; background: gold;'>OTP sent!</span></center>";

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Email doesn't exist!</span></center>";
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
            <button type="submit" name="send" class="btn btn-danger" style="border-radius:0%">Send OTP</button>
        </div>
        <div class="text-center">
            <a href=".">Back</a>
        </div>
    </form>
</div>

<!-- Modal for OTP Sent Confirmation -->
<div class="modal" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">OTP Sent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Your OTP has been sent to your email address. Please check your inbox.</p>
            </div>
        </div>
    </div>
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

<script>
  // Check if OTP was sent and show modal
  <?php if ($error == "<center><span class='text-center badge' style='padding: 8px; background: gold;'>OTP sent!</span></center>") { ?>
      $(document).ready(function() {
          $('#otpModal').modal('show');

          // Close the modal after the session expiration time (e.g., 30 minutes)
          setTimeout(function() {
              $('#otpModal').modal('hide');
          }, <?php echo $otp_expiration_time * 1000; ?>); // Convert to milliseconds
      });
  <?php } ?>
</script>