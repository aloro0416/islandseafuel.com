<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $success = true;
                  ?>
                    <script>
                      document.addEventListener('DOMContentLoaded', function () {
                        <?php if (isset($success) && $success): ?>
                          Swal.fire({
                          icon: 'success',
                          title: 'Sale added',
                          showConfirmButton: true,
                        }).then(() => {
                          window.location.href = 'sales';
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
                          title: 'Sorry failed to add!',
                          showConfirmButton: true,
                        }).then(() => {
                          window.location.href = 'add_sale';
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
            window.location.href = 'add_sale';
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
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Find It</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for product name">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Sale Eidt</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Item </th>
            <th> Price </th>
            <th> Qty </th>
            <th> Total </th>
            <th> Date</th>
            <th> Action</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
