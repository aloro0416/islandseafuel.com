<?php
  $page_title = 'Edit POS';
  require_once('includes/load.php');
 page_require_level(2);
?>
<?php include_once('layouts/header.php'); 

if (isset($_POST['save'])) {
    $pos_id = $_GET['update'];
    $p_liter = remove_junk($db->escape($_POST['liter']));
    $product_id = $_POST['product_id'];
    $amount = remove_junk($db->escape($_POST['amount']));
    $status = $_POST['status'];

    $sql = "SELECT * FROM pos WHERE id='$pos_id'";
    $res = $db->query($sql);
    $row = mysqli_fetch_assoc($res);
    $liter = $row['liter'];

    $sqls = "SELECT * FROM products WHERE id='$product_id'";
    $ress = $db->query($sqls);
    $rows = mysqli_fetch_assoc($ress);
    $quantity = $rows['quantity'];

    $total_liter = $liter + $quantity;

    $pros = "UPDATE products SET quantity = '$total_liter' WHERE id = '$product_id'";
    $db->query($pros);

    $sqlss = "SELECT * FROM products WHERE id='$product_id'";
    $resss = $db->query($sqlss);
    $rowss = mysqli_fetch_assoc($resss);
    $latest_q = $rowss['quantity'];

    $total_lit = $latest_q - $p_liter;

    $prose = "UPDATE products SET quantity = '$total_lit' WHERE id = '$product_id'";
    $db->query($prose);

    
    $pro = "UPDATE pos SET product_id = '$product_id', liter = '$p_liter', amount = '$amount', status = '$status'  WHERE id = '$pos_id'";
    $db->query($pro);

    ?>
    <script>
        $_SESSION['status'] = "Saved!";
        $_SESSION['status_code'] = "success";
        header("Location: edit_pos.php?update='" .$_GET['update'] . "'");
        exit(0);
    </script>
    <?php
}


?>

    <div class="row">
    <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Update POS</span>
     </strong>
     <div class="pull-right">
       <a href="pos.php" class="btn btn-primary">Back</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Customer name</th>
          <th> Product </th>
          <th> Liter </th>
          <th> Amount </th>
          <th> Status</th>
          <th> Action</th>
         </thead>
           <tbody  id="product_info">
            <?php
            $sql = "SELECT * FROM pos WHERE id='".$_GET['update']."'";
            $res = $db->query($sql);
            $row = mysqli_fetch_assoc($res);
                $cus_id = $row['customer_id'];
                $pro_id = $row['product_id'];
                $cus = "SELECT * FROM customer WHERE id = '$cus_id'";
                $cus_res = $db->query($cus);
                $cus_row = mysqli_fetch_assoc($cus_res);

                $pro = "SELECT * FROM products WHERE id = '$pro_id'";
                $pro_res = $db->query($pro);
                $pro_row = mysqli_fetch_assoc($pro_res);
            ?>
              <tr>
              <form method="post">
                <td id="s_name">
                  <input type="text" class="form-control" id="sug_input" name="name" value="<?php if ($row['customer_id'] == 0) { echo "No identity";}else{ echo $cus_row['firstname'] ." ". $cus_row['lastname'];}?>" readonly>
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                <select class="form-control" name="product_id" required>
                    <?php
                    $sel = "SELECT * FROM products"; 
                    $res = $db->query($sel);
                    while ($prod = mysqli_fetch_assoc($res)) {
                       ?>
                        <option value="<?=$prod['id']?>" <?php if ($prod['id'] == $pro_id) {echo "selected";}?>><?=$prod['name']?></option>
                       <?php
                    }
                    ?>
                </select>
                </td>
                <td id="s_price">
                  <input type="text" id="liter" onchange="calculateAmount(this.value)" class="form-control" name="liter"  value="<?=$row['liter']?>" required>
                </td>
                <td>
                <input type="text" class="form-control" name="amount" id="tot_amount" value="<?=$row['amount']?>" readonly>
                </td>
                <td id="s_date">
                <select class="form-control" name="status" required>
                    <option value="0" <?php if ($row['status'] == 0) {echo "selected";}?>>Unpaid</option>
                    <option value="1" <?php if ($row['status'] == 1) {echo "selected";}?>>Paid</option>
                </select>
                </td>
                <td>
                  <button type="submit" name="save" class="btn btn-primary">Save</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>
    </div>
    </div>

    </div>

    
<script>
    function calculateAmount(val) {
        var tot_price = val * <?=$pro_row['sale_price']?>;
        var divobj = document.getElementById('tot_amount');
        divobj.value = tot_price;
    }

    document.getElementById('liter').addEventListener('input', function () {
        var liter = this.value.trim(); 
        
        var isbnPattern = /^[0-9]+$/;
        
        if (this.value !== liter) {
            this.setCustomValidity('ISBN cannot start with a space.');
        } else if (isbnPattern.test(liter)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('Please enter only numbers');
        }
        
        var isValid = isbnPattern.test(liter) && this.value === liter;
        this.classList.toggle('is-invalid', !isValid);
    });
</script>
<?php include_once('layouts/footer.php'); ?>
