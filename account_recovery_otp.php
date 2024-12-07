<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false); }
?>
<?php include_once('layouts/header.php'); 
$error = "";
$otp_sent = false;
$password_updated = false;

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $c_res = $db->query($check_email);
    if (mysqli_num_rows($c_res) > 0) {

        // Generate a random OTP (6 digits)
        $otp = rand(100000, 999999);

        $dup = "SELECT * FROM recovery WHERE email = '$email' AND status = 1";
        $res = $db->query($dup);
        if (mysqli_num_rows($res) > 0) {
            $error = "<center><span class='text-center badge bg-info' style='padding: 8px;'>We already sent you an OTP!</span></center>";
        } else {
            // Insert OTP into recovery table
            $ins = "INSERT INTO recovery (email, recovery_key, status) VALUES ('$email','$otp',1)";
            $ress = $db->query($ins);

            // Create an instance of PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'islandseafuel@gmail.com';
                $mail->Password = 'qyba ckrg odib vzso';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('islandseafuel@gmail.com', 'IslandSea');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'REQUEST OTP FOR ACCOUNT RECOVERY';
                $mail->Body = "
                    <h2>You requested an OTP to recover your account.</h2>
                    <h4>Here is your OTP: <b>$otp</b></h4>
                    <p style='margin-top: 100px;'>Have a good day!</p>
                ";
                $mail->send();

                $otp_sent = true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

    } else {
        $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Email doesn't exist!</span></center>";
    }
}

// Verify OTP and proceed to change password
if (isset($_POST['verify_otp']) && isset($_POST['otp']) && isset($_POST['new_password'])) {
    $user_otp = $_POST['otp'];
    $new_password = $_POST['new_password'];
    $email = $_POST['email'];

    // Check if the OTP is correct
    $check_otp = "SELECT * FROM recovery WHERE email = '$email' AND recovery_key = '$user_otp' AND status = 1";
    $otp_res = $db->query($check_otp);

    if (mysqli_num_rows($otp_res) > 0) {
        // Update password
        $update_password = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
        if ($db->query($update_password)) {
            // Mark recovery as completed
            $update_status = "UPDATE recovery SET status = 0 WHERE email = '$email' AND recovery_key = '$user_otp'";
            $db->query($update_status);

            $password_updated = true;
        }
    } else {
        $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Invalid OTP!</span></center>";
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
    <?php if ($otp_sent && !$password_updated) { ?>
        <!-- OTP Modal -->
        <div class="modal" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter OTP to Proceed</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="clearfix">
                            <div class="form-group">
                                <label for="otp" class="control-label">OTP</label>
                                <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="control-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" placeholder="Enter New Password" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="verify_otp" class="btn btn-danger" style="border-radius:0%">Verify OTP and Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($password_updated) { ?>
        <center><span class='text-center badge bg-success' style='padding: 8px;'>Password updated successfully!</span></center>
    <?php } else { ?>
        <form method="post" class="clearfix">
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" name="send" class="btn btn-danger" style="border-radius:0%">Send OTP</button>
            </div>
            <div class="text-center">
                <a href="account_recovery_select.php">Back</a>
            </div>
        </form>
    <?php } ?>
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
