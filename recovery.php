<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false);}
?>
<?php include_once('layouts/header.php'); 
$error = "";
$email = $_GET['email'];
$key = $_GET['key'];

$check = "SELECT * FROM recovery WHERE email = '$email' AND recovery_key = '$key' AND status = 1";
$c_res = $db->query($check);
if(mysqli_num_rows($c_res) > 0 ){

    if (isset($_POST['changePass'])) {
        $pass = $_POST['password'];
        $Cpass = $_POST['confirmPassword'];
        $hashed = sha1($pass);
        
        if ($pass != $Cpass) {
            $error = "<center><span class='text-center badge bg-danger' style='padding: 8px;'>Password didn't match!</span></center>";
        }else {
           $up = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
           $up_res = $db->query($up);
           $ur = "UPDATE recovery SET status = 0 WHERE email = '$email'";
           $ur_res = $db->query($ur);
           $error = "<center><span class='text-center badge' style='padding: 8px; background: gold;'>Password Changed!</span></center>";
           ?><script>function redirect(){window.location = ".";} setTimeout(redirect, 3000);</script><?php
        }
    }


    ?>
    <div class="login-page">
        <div class="text-center">
            <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
        <h4>ISLAND SEA MANAGEMENT SYSTEMS </h4>
        </div>
        <?php echo $error ?>
        <form method="post" class="clearfix">
            <div class="form-group">
                <label for="password" class="control-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="control-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group text-center">
                    <button type="submit" name="changePass" class="btn btn-danger" style="border-radius:0%">Change Password</button>
            </div>
            <div class="text-center">
                <a href=".">Back</a>
            </div>
        </form>
    </div>
    <?php
}else{
    ?>
    <div class="login-page">
        <div class="text-center">
            <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px">
            <h4>ISLAND SEA MANAGEMENT SYSTEMS </h4>
        </div>
        
        <h4 class="text-danger text-center">Sorry, This link might be used or not valid!</h4>
        <p class="text-center"><a href=".">Back to Login Page</a></p>
    </div>

    <?php
}

?>


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
