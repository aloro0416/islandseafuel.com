<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <div class="data_table">
            <table id="dashprint" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Photo</th>
                <th> Product Title </th>
                <th class="text-center" style="width: 10%;"> Categories </th>
                <th class="text-center" style="width: 10%;"> Quantity / Liters</th>
                <th class="text-center" style="width: 10%;"> Buying Price </th>
                <th class="text-center" style="width: 10%;"> Selling Price </th>
                <th class="text-center" style="width: 10%;"> Product Added </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="" style="object-fit: cover;">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php
                if ($product['quantity'] == 0) {
                  echo "Out of stock";
                }else{
                  echo remove_junk($product['quantity']);
                } ?></td>
                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="confirmDelete(<?=$product['id']?>)">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
              </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>

<script>
   $(document).ready(function(){
        var print = $('#printable').DataTable({
            buttons:[
                'copy', 
                'csv', 
                'excel', 
                'pdf', 
                {
                    extend: 'print',
                    text: 'Print',
                    customize: function (win) {
                        // Add a logo and custom styling to the print output
                        $(win.document.body).prepend(`
                            <div style="text-align: center; margin-bottom: 20px;">
                                <img src="libs/images/logo.png" alt="Company Logo" style="width: 150px;">
                                <h2>ISLAND SEA FUEL</h2>
                                <h4>KANGWAYAN MADRIDEJOS CEBUl</h4>
                            </div>
                        `);
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', '12px');
                    }
                }
            ]
        });

        var dashprint = $('#dashprint').DataTable({
            buttons:[
                'copy', 
                'csv', 
                'excel', 
                'pdf', 
                {
                    extend: 'print',
                    text: 'Print',
                    customize: function (win) {
                        // Add a logo and custom styling to the print output
                        $(win.document.body).prepend(`
                            <div style="text-align: center; margin-bottom: 20px;">
                                <img src="libs/images/logo.png" alt="Company Logo" style="width: 150px;">
                                <h2>ISLAND SEA FUEL</h2>
                                <h4>KANGWAYAN MADRIDEJOS CEBUl</h4>
                            </div>
                        `);
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', '12px');
                    }
                }
            ]
        });

    var dtable = $('#defaultTable').DataTable({
    });

    print.buttons().container()
    .appendTo('#printable_wrapper .col-md-6:eq(0)');

    dashprint.buttons().container()
    .appendTo('#dashprint_wrapper .col-md-6:eq(0)');

 
});

function confirmDelete(productId) {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX request to delete the product
                $.ajax({
                    url: 'delete_product.php', // Your PHP script to handle deletion
                    type: 'GET', // Use GET request
                    data: { id: productId }, // Send the product ID to the PHP script
                    dataType: 'json', // Expecting a JSON response
                    success: function(response) {
                        // Handle success and failure responses from the server
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                response.message, // Show success message from the PHP response
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to update the list
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message, // Show error message from the PHP response
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was a problem with the server.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>