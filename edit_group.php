<?php
  $page_title = 'Edit Group';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $e_group = find_by_id('user_groups',(int)$_GET['id']);
  if(!$e_group){
    $missing = true;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    <?php if (isset($missing) && $missing): ?>
    Swal.fire({
    icon: 'error',
    title: 'Missing Group id',
    showConfirmButton: true,
    }).then(() => {
    window.location.href = 'group';
    })
    <?php endif; ?>
    });
    </script>
    <?php
  }
?>
<?php
  if(isset($_POST['update'])){

   $req_fields = array('group-name','group-level');
   validate_fields($req_fields);
   if(find_by_groupName($_POST['group-name']) === false ){
    $session->msg('d','<b>Sorry!</b> Entered Group Name already in database!');
    redirect('edit_group?id='.(int)$e_group['id'], false);
  }elseif(find_by_groupLevel($_POST['group-level']) === false) {
    $session->msg('d','<b>Sorry!</b> Entered Group Level already in database!');
    redirect('edit_group?id='.(int)$e_group['id'], false);
  }
   if(empty($errors)){
           $name = remove_junk($db->escape($_POST['group-name']));
          $level = remove_junk($db->escape($_POST['group-level']));
         $status = remove_junk($db->escape($_POST['status']));

        $query  = "UPDATE user_groups SET ";
        $query .= "group_name='{$name}',group_level='{$level}',group_status='{$status}'";
        $query .= "WHERE ID='{$db->escape($e_group['id'])}'";
        $result = $db->query($query);
         if($result && $db->affected_rows() === 1){
          $success = true;
          ?>
          <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($success) && $success): ?>
          Swal.fire({
          icon: 'success',
          title: 'Group has been updated!',
          showConfirmButton: true,
          }).then(() => {
          window.location.href = 'edit_group?id=<?php echo $e_group['id']; ?>';
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
          title: 'Sorry failed to updated Group!',
          showConfirmButton: true,
          }).then(() => {
          window.location.href = 'edit_product?id=<?php echo $e_group['id']; ?>';
          })
          <?php endif; ?>
          });
          </script>
          <?php
        }
   } else {
     $session->msg("d", $errors);
    redirect('edit_group?id='.(int)$e_group['id'], false);
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
    window.location.href = 'edit_product?id=<?php echo $e_group['id']; ?>';
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
       <h3>Edit Group</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="edit_group.php?id=<?php echo (int)$e_group['id'];?>" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Group Name</label>
              <input type="name" class="form-control" id="group_name" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Group Level</label>
              <input type="number" class="form-control" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
              <select class="form-control" name="status">
                <option <?php if($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Active </option>
                <option <?php if($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0">Deactive</option>
              </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info">Update</button>
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
