<?php
  $page_title = 'Add User';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','email','password','level' );
   validate_fields($req_fields);
    $mail = $_POST['email'];
    $dup = "SELECT * FROM users WHERE email='$mail'";
    $d_res = $db->query($dup);
    if (mysqli_num_rows($d_res) > 0) {
     //email already exist on db
     $session->msg('d',"Email is already used!");
     redirect('add_user', false);
    }else{
      if(empty($errors)){
        $name   = remove_junk($db->escape($_POST['full-name']));
        $username   = remove_junk($db->escape($_POST['username']));
        $password   = remove_junk($db->escape($_POST['password']));
        $email   = remove_junk($db->escape($_POST['email']));
        $user_level = (int)$db->escape($_POST['level']);
        $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="name,username,email,password,user_level,status";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$email}', '{$password}', '{$user_level}','1'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s',"User account has been created! ");
          redirect('add_user', false);
        } else {
          //sucess
          $session->msg('s',"User account has been created! ");
          redirect('add_user', false);
        }
      } else {
        $session->msg("d", $errors);
        redirect('add_user',false);
      }
    }

  
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name ="password"  placeholder="Password" required>
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
