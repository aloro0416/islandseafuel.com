<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home', false);}
?>
<?php include_once('layouts/header.php');

$key = $_GET['token'];

$check = "SELECT * FROM recovery WHERE recovery_key = '$key' AND status = 1";
$c_res = $db->query($check);
if(mysqli_num_rows($c_res) > 0 ){

    // Fetch the email associated with the recovery key
    $user = mysqli_fetch_assoc($c_res);
    $email = $user['email']; // Use the correct row data from the result set

    if (isset($_POST['changePass'])) {
        $pass = $_POST['password'];
        $Cpass = $_POST['confirmPassword'];
        $hashed = password_hash($pass, PASSWORD_ARGON2I);
        
        if ($pass != $Cpass) {
            $_SESSION['status'] = 'Password didn\'t match!';
            $_SESSION['status_code'] = 'error';
            header('Location: recovery_otp.php');
            exit(0);
        }else {
           $up = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
           $up_res = $db->query($up);
           $ur = "UPDATE recovery SET status = 0 WHERE email = '$email'";
           $ur_res = $db->query($ur);
           $_SESSION['status'] = 'Password Changed Successfully!';
            $_SESSION['status_code'] = 'success';
            header('Location: .');
            exit(0);
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
                <input type="hidden" name="email" value="<?php echo $email ?>" required>
            </div>
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
