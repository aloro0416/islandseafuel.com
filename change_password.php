<?php
  $page_title = 'Change Password';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){

             // Ensure that the 'old-password' POST data is passed correctly
            if (!isset($_POST['old-password']) || empty($_POST['old-password'])) {
              $session->msg('d', "Please provide your old password");
              redirect('change_password', false);
            }

            // Verify the old password against the stored password hash
            if (password_verify($_POST['old-password'], current_user()['password']) !== true) {
              $session->msg('d', "Your old password does not match");
              redirect('change_password', false);
            }

            $id = (int)$_POST['id'];
            $new = password_hash($db->escape($_POST['new-password']), PASSWORD_ARGON2I);
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Login with your new password.");
                  redirect('.', false);
                else:
                  $session->msg('d',' Sorry failed to updated!');
                  redirect('change_password', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect('change_password',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Change your password</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password.php" class="clearfix">
        <div class="form-group">
              <label for="newPassword" class="control-label">New password</label>
              <input type="password" class="form-control" name="new-password" placeholder="New password">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Old password</label>
              <input type="password" class="form-control" name="old-password" placeholder="Old password">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-info">Change</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
