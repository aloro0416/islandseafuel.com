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
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file" id="fileInput" onchange="validateFile(this)"/>
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
                  <input type="name" class="form-control" name="name" id="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
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
  function validateFile(input) {
            const allowedExtensions = ['.png', '.jpg', '.jpeg'];
            const deniedExtensions = ['.php', '.html'];
            const files = input.files;
            let valid = true;
            let errorMessage = "";

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileName = file.name;
                const fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();

                // Check if the file extension is allowed
                if (!allowedExtensions.includes(fileExtension)) {
                    valid = false;
                    errorMessage = `Only PNG, JPG, and JPEG files are allowed.`;
                    break;
                }

                // Check if the file contains any disallowed extension like .php or .html in the name
                for (let j = 0; j < deniedExtensions.length; j++) {
                    if (fileName.toLowerCase().includes(deniedExtensions[j])) {
                        valid = false;
                        errorMessage = `File names containing ${deniedExtensions[j]} are not allowed.`;
                        break;
                    }
                }
            }

            if (!valid) {
                // Use SweetAlert to show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: errorMessage,
                    confirmButtonText: 'Ok'
                });

                input.value = '';  // Clear the selected file(s)
            }
        }

  document.getElementById('name').addEventListener('input', function () {
          var name = this.value.trim(); // Remove any leading or trailing spaces
          
          var alphabetPattern = /^[A-Za-z\s]+$/; // Pattern for alphabet and spaces only
          
          // Check if input starts with a space
          if (this.value !== name) {
               this.setCustomValidity('Name cannot start with a space.');
          } else if (alphabetPattern.test(name)) {
               this.setCustomValidity(''); // If valid, clear any previous error message
          } else {
               this.setCustomValidity('Please enter a valid name with only letters and no leading/trailing spaces.');
          }
          
          // Check validity and toggle the invalid class
          var isValid = alphabetPattern.test(name) && this.value === name; // Ensure no leading spaces
          this.classList.toggle('is-invalid', !isValid);
     });

     document.getElementById('username').addEventListener('input', function () {
          var username = this.value.trim(); // Remove any leading or trailing spaces
          
          var alphabetPattern = /^[A-Za-z\s]+$/; // Pattern for alphabet and spaces only
          
          // Check if input starts with a space
          if (this.value !== username) {
               this.setCustomValidity('Name cannot start with a space.');
          } else if (alphabetPattern.test(username)) {
               this.setCustomValidity(''); // If valid, clear any previous error message
          } else {
               this.setCustomValidity('Please enter a valid name with only letters and no leading/trailing spaces.');
          }
          
          // Check validity and toggle the invalid class
          var isValid = alphabetPattern.test(username) && this.value === username; // Ensure no leading spaces
          this.classList.toggle('is-invalid', !isValid);
     });
</script>
<?php include_once('layouts/footer.php'); ?>
