<?php
  $page_title = 'POS';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
?>
<?php include_once('layouts/header.php'); 
$msg = "";
if (isset($_POST['add'])) {
    $first = $_POST['firstname'];
    $middle = $_POST['middlename'];
    $last = $_POST['lastname'];
    $type = $_POST['type'];

    $sql = "SELECT * FROM customer WHERE firstname = '$first' AND middlename = '$middle' AND lastname = '$last'";
    $result = $db->query($sql);
    if (mysqli_num_rows($result) > 0) {
        $msg = "<span class='warning-msg'>Customer Already Exist!</span>";
    }else{
        $sqls = "INSERT INTO customer (firstname,middlename,lastname,customer_type) VALUES ('$first','$middle','$last','$type')";
        $result = $db->query($sqls);
        $msg = "<span class='alert-msg'>Successfully Added!</span>";
        header('location: pos?proc=customer');
    }
}elseif (isset($_POST['update'])) {
    $first = $_POST['firstname'];
    $middle = $_POST['middlename'];
    $last = $_POST['lastname'];
    $type = $_POST['type'];
    $sql = "UPDATE customer SET firstname = '$first' , middlename = '$middle' , lastname = '$last' , customer_type = '$type' WHERE id = '".$_GET['update']."'";
    $result = $db->query($sql);
    $msg = "<span class='alert-msg'>Successfully Updated!</span>";
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
                        <input type="text" class="form-control" name="firstname" value="<?=$row['firstname']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Middlename (Optional)</label>
                        <input type="text" class="form-control" name="middlename" value="<?=$row['middlename']?>">
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Lastname</label>
                        <input type="text" class="form-control" name="lastname" value="<?=$row['lastname']?>" required>
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
                        <input type="text" class="form-control" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Middlename (Optional)</label>
                        <input type="text" class="form-control" name="middlename">
                    </div>
                    <div class="form-group">
                        <label for="level" class="control-label">Lastname</label>
                        <input type="text" class="form-control" name="lastname" required>
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

<?php include_once('layouts/footer.php'); ?>
