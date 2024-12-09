<?php
  $page_title = 'Add Group';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  if(isset($_POST['add'])){

   $req_fields = array('group-name','group-level');
   validate_fields($req_fields);

   if(find_by_groupName($_POST['group-name']) === false ){
     $session->msg('d','<b>Sorry!</b> Entered Group Name already in database!');
     redirect('add_group', false);
   }elseif(find_by_groupLevel($_POST['group-level']) === false) {
     $session->msg('d','<b>Sorry!</b> Entered Group Level already in database!');
     redirect('add_group', false);
   }
   if(empty($errors)){
           $name = remove_junk($db->escape($_POST['group-name']));
          $level = remove_junk($db->escape($_POST['group-level']));
         $status = remove_junk($db->escape($_POST['status']));

        $query  = "INSERT INTO user_groups (";
        $query .="group_name,group_level,group_status";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$level}','{$status}'";
        $query .=")";
        if($db->query($query)){
          $success = true;
          ?>
          <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($success) && $success): ?>
          Swal.fire({
          icon: 'success',
          title: 'Group has been creted!',
          showConfirmButton: true,
          }).then(() => {
          window.location.href = 'add_group';
          })
          <?php endif; ?>
          });
          </script>
          <?php
        } else {
          $failed = true;
          ?>
          <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($failed) && $failed): ?>
          Swal.fire({
          icon: 'error',
          title: 'Sorry failed to create Group!',
          showConfirmButton: true,
          }).then(() => {
          window.location.href = 'add_group';
          })
          <?php endif; ?>
          });
          </script>
          <?php
        }
   } else {
      $error = true;
          ?>
          <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($error) && $error): ?>
          Swal.fire({
          icon: 'error',
          title: $errors,
          showConfirmButton: true,
          }).then(() => {
          window.location.href = 'add_group';
          })
          <?php endif; ?>
          });
          </script>
          <?php
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Add new user Group</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="add_group.php" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Group Name</label>
              <input type="name" class="form-control" id="group_name" name="group-name">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Group Level</label>
              <input type="number" class="form-control" name="group-level">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
            <select class="form-control" name="status">
              <option value="1">Active</option>
              <option value="0">Deactive</option>
            </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="add" class="btn btn-info">Update</button>
        </div>
    </form>
</div>

<script>
  document.getElementById('group_name').addEventListener('input', function () {
        var group_name = this.value.trim();
        
        var dangerousCharsPattern = /[<>\"\']/;
        
        if (group_name === "") {
            this.setCustomValidity('Group name cannot be empty or just spaces.');
        } else if (this.value !== group_name) {
            this.setCustomValidity('Group name cannot start with a space.');
        } else if (dangerousCharsPattern.test(group_name)) {
            this.setCustomValidity('Group name cannot contain HTML special characters like <, >, ", \'.');
        } else {
            this.setCustomValidity('');
        }
        
        var isValid = group_name !== "" && this.value === group_name && !dangerousCharsPattern.test(group_name);
        this.classList.toggle('is-invalid', !isValid);
    });
</script>
<?php include_once('layouts/footer.php'); ?>
