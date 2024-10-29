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
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name= "password" class="form-control" id="myInput" placeholder="Password">
            <!-- An element to toggle between password visibility -->
            <input type="checkbox" onclick="myFunction()">Show Password
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
        <div class="text-center">
            <a href="account_recovery.php">Forgot password?</a>
        </div>
    </form>
</div>
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
