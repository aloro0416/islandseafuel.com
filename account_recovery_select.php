<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
       <h4>ISLAND SEA MANAGEMENT SYSTEM</h4>
    </div>
     <?php echo display_msg($msg); ?>
        <div class="form-group">
              <a href="account_recovery.php">Reset via email link</a>
        </div>
        <div class="form-group">
            <a href="account_recovery_otp.php">Reset via email otp</a>
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
        <div class="text-center">
            <a href="account_recovery.php">Forgot password?</a>
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
