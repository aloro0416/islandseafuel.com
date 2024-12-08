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
     <?php if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']): ?>
                        <?php
                        $lockout_time_remaining = $_SESSION['lockout_time'] - time();
                        $minutes_remaining = ceil($lockout_time_remaining / 60);
                        ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const formInputs = document.querySelectorAll('#username, #myInput');
                                const loginButton = document.getElementById('btn_login');
                                
                                formInputs.forEach(input => input.disabled = true);
                                loginButton.disabled = true;

                                Swal.fire({
                                    title: 'Account Locked',
                                    text: "Your account is locked. Please wait " + <?php echo $minutes_remaining; ?> + " minute(s) before trying again.",
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false, 
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                }).then(() => {
                                    setTimeout(function() {
                                        window.location.reload(); 
                                    }, 1000);
                                });
                            });
                        </script>
                    <?php endif; ?>
     <!-- Include Google reCAPTCHA v3 Script -->
     <script src="https://www.google.com/recaptcha/api.js?render=6Lcc25IqAAAAAH635KLYx5TwcXhguTYoIdJzgceI"></script>

     <form method="post" action="auth.php" class="clearfix" id="loginForm">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" id="username" placeholder="Username" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?>>
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name= "password" class="form-control" id="myInput" placeholder="Password" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?>>
            <!-- An element to toggle between password visibility -->
            <input type="checkbox" onclick="myFunction()"> <span class="text-muted">Show Password</span>
        </div>
        <!-- Hidden reCAPTCHA token input will be added here -->
        <div class="form-group">
            <button type="submit" id="btn-login" class="btn btn-danger" style="border-radius:0%" <?php if (isset($lockout_time_remaining)) echo 'disabled'; ?>>Login</button>
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

<?php
  if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Login Successful',
          showConfirmButton: true
        }).then(() => {
          window.location.href = 'admin';
        });
      });
    </script>
    <?php
    unset($_SESSION['login_success']);
  }
?>

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
