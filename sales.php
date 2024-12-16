<?php
  $page_title = 'All sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_all_sale();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>All Sales</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale" class="btn btn-primary">Add sale</a>
          </div>
        </div>
        <div class="panel-body">
           <div class="data_table">
            <table id="dashprint" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['name']); ?></td>
               <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
               <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
               <td class="text-center"><?php echo $sale['date']; ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_sale?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="confirmDelete(<?=$sale['id']?>)">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
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

        var dtable = $('#defaultTable').DataTable({});

        print.buttons().container()
            .appendTo('#printable_wrapper .col-md-6:eq(0)');

        dashprint.buttons().container()
            .appendTo('#dashprint_wrapper .col-md-6:eq(0)');
    });

    function confirmDelete(saleId) {
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
                $.ajax({
                    url: 'delete_sale.php',
                    type: 'GET',
                    data: { id: saleId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
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

