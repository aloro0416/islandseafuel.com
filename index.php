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
     <!-- Include Google reCAPTCHA v3 Script -->
     <script src="https://www.google.com/recaptcha/api.js?render=6Lcc25IqAAAAAH635KLYx5TwcXhguTYoIdJzgceI"></script>

     <form method="post" action="auth.php" class="clearfix" id="loginForm">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <!-- Hidden reCAPTCHA token input will be added here -->
        <div class="form-group">
            <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
        <div class="text-center">
            <a href="account_recovery.php">Forgot password?</a>
        </div>
    </form>

    <!-- JavaScript for reCAPTCHA token generation -->
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Lcc25IqAAAAAH635KLYx5TwcXhguTYoIdJzgceI', {action: 'login'}).then(function(token) {
                // Add the token as a hidden input field in the form
                var recaptchaInput = document.createElement('input');
                recaptchaInput.type = 'hidden';
                recaptchaInput.name = 'recaptcha_token';
                recaptchaInput.value = token;
                document.getElementById('loginForm').appendChild(recaptchaInput);
            });
        });
    </script>
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
