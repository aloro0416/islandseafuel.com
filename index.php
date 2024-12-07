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
            <input type="password" name= "password" class="form-control" id="myInput" placeholder="Password">
            <!-- An element to toggle between password visibility -->
            <input type="checkbox" onclick="myFunction()"> <span class="text-muted">Show Password</span>
        </div>
        <!-- Hidden reCAPTCHA token input will be added here -->
        <div class="form-group">
            <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
        <div class="text-center">
            <a href="account_recovery_select.php">Forgot password?</a>
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

<script>
  function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

</div>

<style>
  body {
    background-image: url('libs/images/bgi2.jpg');
    background-size: cover; /* Ensures the image covers the entire screen */
    background-position: center;
    background-attachment: fixed; /* Keeps the background fixed while scrolling */
  }

  .login-page {
    box-shadow: 2px 2px 5px 2px;
  }

  /* Media query for mobile devices */
  @media (max-width: 768px) {
    body {
      background-size: contain; /* Adjusts the background size for smaller screens */
      background-position: top center; /* Aligns the image to the top center for better display on mobile */
      background-attachment: scroll; /* Fixes the background scrolling issue on mobile */
      padding: 35px 15px 20px 15px; /* Adjust padding for smaller screens */
      top: 20px; /* Reduce the top margin for mobile */
      left: 0;
      width: 100%; /* Ensure full-width on smaller screens */
    }
  }
</style>


<?php include_once('layouts/footer.php'); ?>
