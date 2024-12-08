<?php
  $page_title = 'POS';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
 page_require_level(2);
?>
<?php include_once('layouts/header.php'); 
$msg = "";
if (isset($_POST['add'])) {
   $first = remove_junk($db->escape($_POST['firstname']));
    $middle = remove_junk($db->escape($_POST['middlename']));
    $last = remove_junk($db->escape($_POST['lastname']));;
    $type = remove_junk($db->escape($_POST['type']));;

    $sql = "SELECT * FROM customer WHERE firstname = '$first' AND middlename = '$middle' AND lastname = '$last'";
    $result = $db->query($sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = "Customer Already Exist!";
        $_SESSION['status_code'] = "warning";
        header("Location: add_customer.php");
        exit(0);
    }else{
        $sqls = "INSERT INTO customer (firstname,middlename,lastname,customer_type) VALUES ('$first','$middle','$last','$type')";
        $result = $db->query($sqls);
        $_SESSION['status'] = "Successfully Added!";
        $_SESSION['status_code'] = "success";
        header("Location: pos.php?proc=customer");
        exit(0);
    }
}elseif (isset($_POST['update'])) {
   $first = remove_junk($db->escape($_POST['firstname']));
    $middle = remove_junk($db->escape($_POST['middlename']));
    $last = remove_junk($db->escape($_POST['lastname']));;
    $type = remove_junk($db->escape($_POST['type']));;
    $sql = "UPDATE customer SET firstname = '$first' , middlename = '$middle' , lastname = '$last' , customer_type = '$type' WHERE id = '".$_GET['update']."'";
    $result = $db->query($sql);
    $_SESSION['status'] = "Successfully Updated!";
    $_SESSION['status_code'] = "success";
    header("Location: add_customer");
    exit(0);
}
?>
<div class="row">
    <div class="login-page">
        <?php 
        if (isset($_GET['update'])) {
            $sql = "SELECT * FROM customer WHERE id= '".$_GET['update']."' ";
            $res = $db->query($sql);
            $row = mysqli_fetch_assoc($res);
            ?>
            <div class="text-center">
                <h3>Update customer</h3>
                <?=$msg?>
                </div>
                <form method="post" class="clearfix">
                    <div class="form-group">
                        <label for="name" class="control-label">Firstname</label>
                        <input type="text" id="firstname" class="form-control" name="firstname" value="<?=$row['firstname']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Middlename (Optional)</label>
                        <input type="text" id="middlename" class="form-control" name="middlename" value="<?=$row['middlename']?>">
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Lastname</label>
                        <input type="text" id="lastname" class="form-control" name="lastname" value="<?=$row['lastname']?>" required>
                    </div>
                    <div class="form-group">
                    <label for="type">Customer Type</label>
                        <select class="form-control" name="type" required>
                        <option value="<?=$row['customer_type']?>" selected><?=$row['customer_type']?></option>
                        <option value="Regular">Regular</option>
                        <option value="Suki">Suki</option>
                        </select>
                    </div>
                    <div class="form-group clearfix text-center">
                            <button type="submit" name="update" class="btn btn-primary">Save</button>
                            <a href="pos.php?proc=customer" class="btn btn-info">Cancel</a>
                    </div>
                </form>
            <?php
        }else{
            ?>
                <div class="text-center">
                <h3>Add new customer</h3>
                <?=$msg?>
                </div>
                <form method="post" class="clearfix">
                    <div class="form-group">
                        <label for="name" class="control-label">Firstname</label>
                        <input type="text" id="firstname" class="form-control" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Middlename (Optional)</label>
                        <input type="text" id="middlename" class="form-control" name="middlename">
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Lastname</label>
                        <input type="text" id="lastname" class="form-control" name="lastname" required>
                    </div>
                    <div class="form-group">
                    <label for="type">Customer Type</label>
                        <select class="form-control" name="type" required>
                        <option value="Regular">Regular</option>
                        <option value="Suki">Suki</option>
                        </select>
                    </div>
                    <div class="form-group clearfix text-center">
                            <button type="submit" name="add" class="btn btn-primary">Add</button>
                            <a href="pos.php?proc=customer" class="btn btn-info">Back</a>
                    </div>
                </form>
            <?php
        }
        ?>
    </div>
</div>

<script>
    document.getElementById('firstname').addEventListener('input', function () {
          var firstname = this.value.trim(); // Remove any leading or trailing spaces
          
          var alphabetPattern = /^[A-Za-z\s]+$/; // Pattern for alphabet and spaces only
          
          // Check if input starts with a space
          if (this.value !== firstname) {
               this.setCustomValidity('Name cannot start with a space.');
          } else if (alphabetPattern.test(firstname)) {
               this.setCustomValidity(''); // If valid, clear any previous error message
          } else {
               this.setCustomValidity('Please enter a valid name with only letters and no leading/trailing spaces.');
          }
          
          // Check validity and toggle the invalid class
          var isValid = alphabetPattern.test(firstname) && this.value === firstname; // Ensure no leading spaces
          this.classList.toggle('is-invalid', !isValid);
     });

     document.getElementById('lastname').addEventListener('input', function () {
          var lastname = this.value.trim(); // Remove any leading or trailing spaces
          
          var alphabetPattern = /^[A-Za-z\s]+$/; // Pattern for alphabet and spaces only
          
          // Check if input starts with a space
          if (this.value !== lastname) {
               this.setCustomValidity('Name cannot start with a space.');
          } else if (alphabetPattern.test(lastname)) {
               this.setCustomValidity(''); // If valid, clear any previous error message
          } else {
               this.setCustomValidity('Please enter a valid name with only letters and no leading/trailing spaces.');
          }
          
          // Check validity and toggle the invalid class
          var isValid = alphabetPattern.test(lastname) && this.value === lastname; // Ensure no leading spaces
          this.classList.toggle('is-invalid', !isValid);
     });

     document.getElementById('middlename').addEventListener('input', function () {
          var middlename = this.value.trim(); // Remove any leading or trailing spaces
          
          var alphabetPattern = /^[A-Za-z\s]+$/; // Pattern for alphabet and spaces only
          
          // Check if input starts with a space
          if (this.value !== middlename) {
               this.setCustomValidity('Name cannot start with a space.');
          } else if (alphabetPattern.test(middlename)) {
               this.setCustomValidity(''); // If valid, clear any previous error message
          } else {
               this.setCustomValidity('Please enter a valid name with only letters and no leading/trailing spaces.');
          }
          
          // Check validity and toggle the invalid class
          var isValid = alphabetPattern.test(middlename) && this.value === middlename; // Ensure no leading spaces
          this.classList.toggle('is-invalid', !isValid);
     });
</script>

<?php include_once('layouts/footer.php'); ?>
