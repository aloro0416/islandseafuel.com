<?php
  $page_title = 'Edit Account';
  require_once('includes/load.php');
   page_require_level(3);
?>
<?php
//update user image
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $user_id = (int)$_POST['user_id'];
  $photo->upload($_FILES['file_upload']);
  if($photo->process_user($user_id)){
    $session->msg('s','photo has been uploaded.');
    redirect('edit_account');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('edit_account');
    }
  }
?>
<?php
 //update user other info
  if(isset($_POST['update'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$_SESSION['user_id'];
           $name = remove_junk($db->escape($_POST['name']));
       $username = remove_junk($db->escape($_POST['username']));
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Acount updated ");
            redirect('edit_account', false);
          } else {
            $session->msg('d',' Sorry failed to updated!');
            redirect('edit_account', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_account',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change My photo</span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
                <img class="img-circle img-size-2" src="uploads/users/<?php echo $user['image'];?>" alt="" style="object-fit: cover;">
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file" id="fileInput"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                 <button type="submit" name="submit" class="btn btn-warning">Change</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit My Account</span>
      </div>
      <div class="panel-body">
          <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
          <div class="form-group">
              <label for="name" class="control-label">Name</label>
              <input type="text" class="form-control" name="name" id="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>" 
              pattern="^[A-Za-z]+([ A-Za-z]+)*$" 
              title="Please enter a valid name with only letters and spaces, no leading or trailing spaces." required>
          </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" id="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
            </div>
            <div class="form-group clearfix">
                    <a href="change_password" title="change password" class="btn btn-danger pull-right">Change Password</a>
                    <button type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('fileInput').addEventListener('change', function(event) {
    const files = event.target.files;
    const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (!allowedTypes.includes(file.type)) {
        // Show SweetAlert for invalid file type
        Swal.fire({
          icon: 'error',
          title: 'Invalid file type',
          text: 'Only .png, .jpg, .jpeg files are allowed.',
        });
        event.target.value = ''; // Clear input
        return;
      }
      if (file.size > maxSize) {
        // Show SweetAlert for file size error
        Swal.fire({
          icon: 'error',
          title: 'File too large',
          text: 'Each file must be smaller than 2MB.',
        });
        event.target.value = ''; // Clear input
        return;
      }
    }
  });

  document.getElementById('name').addEventListener('input', function () {
     var name = this.value.trim();
     
     var alphabetPattern = /^[A-Za-z\s]+$/;
     
     if (alphabetPattern.test(name)) {
          this.setCustomValidity(''); 
     } else {
          this.setCustomValidity('Please enter a valid name with only letters and no only spaces or space first.');
     }
     
     var isValid = alphabetPattern.test(name);
     this.classList.toggle('is-invalid', !isValid);
     });

     document.getElementById('username').addEventListener('input', function () {
     var username = this.value.trim();
     
     var alphabetPattern = /^[A-Za-z\s]+$/;
     
     if (alphabetPattern.test(username)) {
          this.setCustomValidity(''); 
     } else {
          this.setCustomValidity('Please enter a valid username with only letters and no only spaces or space first.');
     }
     
     var isValid = alphabetPattern.test(username);
     this.classList.toggle('is-invalid', !isValid);
     });
</script>
<?php include_once('layouts/footer.php'); ?>
