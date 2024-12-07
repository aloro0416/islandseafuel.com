<?php
  ob_start();
  require_once('includes/load.php');
  if ($session->isUserLoggedIn(true)) { redirect('home', false); }

  include_once('layouts/header.php'); 
  $error = "";

  // Import PHPMailer classes
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  if (isset($_POST['send'])) {
      $email = $_POST['email'];
      $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $c_res = $stmt->get_result();

      if ($c_res->num_rows > 0) {
          // Generate OTP
          $otp = rand(100000, 999999);

          // Check if OTP is already sent
          $stmt = $db->prepare("SELECT * FROM recovery WHERE email = ? AND status = 1");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $res = $stmt->get_result();

          if ($res->num_rows > 0) {
              $error = "<center><span class='text-center badge bg-info' style='padding: 8px;'>We already sent you an OTP!</span></center>";
          } else {
              // Insert OTP into recovery table
              $stmt = $db->prepare("INSERT INTO recovery (email, recovery_key, status) VALUES (?, ?, 1)");
              $stmt->bind_param("ss", $email, $otp);
              $stmt->execute();

              // Send OTP email
              $mail = new PHPMailer(true);
              try {
                  $mail->isSMTP();
                  $mail->Host = 'smtp.gmail.com';
                  $mail->SMTPAuth = true;
                  $mail->Username = 'islandsea2001@gmail.com';
                  $mail->Password = 'bkggsnzgpxrzrovb'; 
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                  $mail->Port = 587;
                  $mail->setFrom('islandsea2001@gmail.com', 'IslandSea');
                  $mail->addAddress($email);
                  $mail->isHTML(true);
                  $mail->Subject = 'Your OTP for Account Recovery';
                  $mail->Body = '<h2>You requested an account recovery OTP.</h2><h4>Your OTP is: <b>' . $otp . '</b></h4>';
                  $mail->send();

                  $error = "<center><span class='text-center badge' style='padding: 8px; background: gold;'>OTP sent!</span></center>";
              } catch (Exception $e) {
                  $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Error: {$mail->ErrorInfo}</span></center>";
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

<script>
  <?php if (isset($error) && $error == "<center><span class='text-center badge' style='padding: 8px; background: gold;'>OTP sent!</span></center>") { ?>
      $(document).ready(function() {
          $('#otpModal').modal('show');
          setTimeout(function() {
              $('#otpModal').modal('hide');
          }, 30000); // 30 seconds
      });
  <?php } ?>
</script>

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
