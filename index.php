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
              <input type="name" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
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
  body {
    background-image: url('libs/images/bgi2.jpg');
    background-size: cover;
    background-position: center;
    margin: 0;
    font-family: Arial, sans-serif;
  }
  
  .login-page {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .login-page .text-center {
    margin-bottom: 20px;
  }

  .login-page img {
    width: 100px;
    height: auto;
  }

  .login-page h4 {
    font-size: 20px;
    margin-top: 10px;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  .btn {
    width: 100%;
    padding: 10px;
    background-color: #d9534f;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .btn:hover {
    background-color: #c9302c;
  }

  .text-center a {
    color: #d9534f;
    font-size: 14px;
    text-decoration: none;
  }

  .text-center a:hover {
    text-decoration: underline;
  }

  /* Responsive Styles */
  @media (max-width: 576px) {
    .login-page {
      padding: 20px;
      margin: 10px;
    }

    .login-page h4 {
      font-size: 18px;
    }

    .form-control {
      font-size: 14px;
      padding: 8px;
    }

    .btn {
      font-size: 14px;
      padding: 8px;
    }
  }
</style>

<?php include_once('layouts/footer.php'); ?>
