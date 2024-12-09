<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sale = find_by_id('sales',(int)$_GET['id']);
if(!$sale){
  $missing = true;
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    <?php if (isset($missing) && $missing): ?>
      Swal.fire({
        icon: 'error',
        title: 'Missing product id.',
        showConfirmButton: true,
      }).then(() => {
        window.location.href = 'sales';
      })
    <?php endif; ?>
    });
  </script>
  <?php
}
?>
<?php $product = find_by_id('products',$sale['product_id']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('title','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$product['id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = date("Y-m-d", strtotime($date));

          $sql  = "UPDATE sales SET";
          $sql .= " product_id= '{$p_id}',qty={$s_qty},price='{$s_total}',date='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                    update_product_qty($s_qty,$p_id);
                    $success = true;
                    ?>
                      <script>
                        document.addEventListener('DOMContentLoaded', function () {
                        <?php if (isset($success) && $success): ?>
                          Swal.fire({
                          icon: 'success',
                          title: 'Sale updated!',
                          showConfirmButton: true,
                        }).then(() => {
                          window.location.href = 'edit_sale?id=<?php echo $sale['id']; ?>';
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
                          title: 'Sorry failed to updated!',
                          showConfirmButton: true,
                        }).then(() => {
                          window.location.href = 'sales';
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
                    window.location.href = 'edit_sale?id=<?php echo (int)$sale['id']; ?>';
                  })
                <?php endif; ?>
              });
            </script>
          <?php
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>All Sales</span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-primary">Show all sales</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Product title </th>
          <th> Qty </th>
          <th> Price </th>
          <th> Total </th>
          <th> Date</th>
          <th> Action</th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
                <td id="s_name">
                  <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo remove_junk($product['name']); ?>">
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                  <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo (int)$sale['qty']; ?>">
                </td>
                <td id="s_price">
                  <input type="number" class="form-control" id="price" name="price" value="<?php echo remove_junk($product['sale_price']); ?>" >
                </td>
                <td>
                  <input type="text" class="form-control" name="total" value="<?php echo remove_junk($sale['price']); ?>" readonly>
                </td>
                <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>">
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<script>
  document.getElementById('sug_input').addEventListener('input', function () {
        var sug_input = this.value.trim();
        
        var dangerousCharsPattern = /[<>\"\']/;
        
        if (sug_input === "") {
            this.setCustomValidity('Product title cannot be empty or just spaces.');
        } else if (this.value !== sug_input) {
            this.setCustomValidity('Product title cannot start with a space.');
        } else if (dangerousCharsPattern.test(sug_input)) {
            this.setCustomValidity('Product title cannot contain HTML special characters like <, >, ", \'.');
        } else {
            this.setCustomValidity('');
        }
        
        var isValid = sug_input !== "" && this.value === sug_input && !dangerousCharsPattern.test(sug_input);
        this.classList.toggle('is-invalid', !isValid);
    });

    document.getElementById('quantity').addEventListener('input', function () {
        var quantity = this.value.trim();

        var dangerousCharsPattern = /[<>\"']/;
        var numericPattern = /^[0-9]*$/;  // Only allows numbers
        
        if (quantity === "") {
            this.setCustomValidity('Quantity cannot be empty or just spaces.');
        } else if (this.value !== quantity) {
            this.setCustomValidity('Quantity cannot start with a space.');
        } else if (dangerousCharsPattern.test(quantity)) {
            this.setCustomValidity('Quantity cannot contain HTML special characters like <, >, ", \'.');
        } else if (!numericPattern.test(quantity)) {
            this.setCustomValidity('Please enter only numbers.');
        } else {
            this.setCustomValidity('');
        }

        var isValid = quantity !== "" && this.value === quantity && !dangerousCharsPattern.test(quantity) && numericPattern.test(quantity);
        this.classList.toggle('is-invalid', !isValid);
    });

    document.getElementById('price').addEventListener('input', function () {
        var price = this.value.trim();

        var dangerousCharsPattern = /[<>\"']/;
        var numericPattern = /^[0-9]*$/;  // Only allows numbers
        
        if (price === "") {
            this.setCustomValidity('Price cannot be empty or just spaces.');
        } else if (this.value !== price) {
            this.setCustomValidity('Price cannot start with a space.');
        } else if (dangerousCharsPattern.test(price)) {
            this.setCustomValidity('Price cannot contain HTML special characters like <, >, ", \'.');
        } else if (!numericPattern.test(price)) {
            this.setCustomValidity('Please enter only numbers.');
        } else {
            this.setCustomValidity('');
        }

        var isValid = price !== "" && this.value === price && !dangerousCharsPattern.test(price) && numericPattern.test(quantity);
        this.classList.toggle('is-invalid', !isValid);
    });
</script>

<?php include_once('layouts/footer.php'); ?>
