<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO products (";
     $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $success = true;
       ?>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($success) && $success): ?>
            Swal.fire({
            icon: 'success',
            title: 'Product added',
            showConfirmButton: true,
          }).then(() => {
            window.location.href = 'product';
          })
            <?php endif; ?>
          });
        </script>
       <?php
     } else {
       $error = true;
       ?>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($error) && $error): ?>
            Swal.fire({
            icon: 'error',
            title: 'Sorry failed to added!',
            showConfirmButton: 'Ok',
          }).then(() => {
            window.location.href = 'product';
          })
            <?php endif; ?>
          });
        </script>
       <?php
     }

   } else{
     $danger = true;
       ?>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
          <?php if (isset($danger) && $danger): ?>
            Swal.fire({
            icon: 'error',
            title: $errors,
            showConfirmButton: 'Ok',
          }).then(() => {
            window.location.href = 'add_product';
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
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" id="product-title" placeholder="Product Title">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Select Product Category</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value="">Select Product Photo</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Quantity / Liter">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-coins"><span style="font-size: 1.2 em;">₱</span> </i>
                     </span>
                     <input type="number" class="form-control" name="buying-price" placeholder="Buying Price">
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-coins"><span style="font-size: 1.2 em;">₱</span></i>
                      </span>
                      <input type="number" class="form-control" name="saleing-price" placeholder="Selling Price">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('product-title').addEventListener('input', function () {
        var product = this.value.trim();
        
        var dangerousCharsPattern = /[<>\"\']/;
        
        if (product === "") {
            this.setCustomValidity('Product title cannot be empty or just spaces.');
        } else if (this.value !== product) {
            this.setCustomValidity('Product title cannot start with a space.');
        } else if (dangerousCharsPattern.test(product)) {
            this.setCustomValidity('Product title cannot contain HTML special characters like <, >, ", \'.');
        } else {
            this.setCustomValidity('');
        }
        
        var isValid = product !== "" && this.value === product && !dangerousCharsPattern.test(product);
        this.classList.toggle('is-invalid', !isValid);
    });
  </script>

<?php include_once('layouts/footer.php'); ?>
