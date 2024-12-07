<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
       <h4>ISLAND SEA MANAGEMENT SYSTEM</h4>
    </div>
     <?php echo display_msg($msg); ?>
        <div class="form-group">
              <a href="account_recovery.php" class="form-control text-center" style="text-decoration:none;">Reset via email link</a>
        </div>
        <div class="form-group">
            <a href="account_recovery_otp.php" class="form-control text-center" style="text-decoration:none;">Reset via email otp</a>
        </div>
        <div class="text-center">
            <a href=".">Back</a>
        </div>
</div>

<style>
  body{
    background-image: url('libs/images/bgi2.jpg');
    background-size: cover;
    background-position: center;
  }
  .login-page{
    box-shadow: 2px 2px 5px 2px;
  }
</style>

<?php include_once('layouts/footer.php'); ?>
