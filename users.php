<?php
  $page_title = 'All User';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = find_all_user();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Users</span>
       </strong>
         <a href="add_user" class="btn btn-info pull-right">Add New User</a>
      </div>
     <div class="panel-body">
      <div class="data_table">
        <table id="dashprint" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Name </th>
            <th>Username</th>
            <th class="text-center" style="width: 15%;">User Role</th>
            <th class="text-center" style="width: 10%;">Status</th>
            <th style="width: 20%;">Last Login</th>
            <th class="text-center" style="width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_users as $a_user): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
           <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
           <td class="text-center">
           <?php if($a_user['status'] === '1'): ?>
            <span class="label label-success"><?php echo "Active"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Deactive"; ?></span>
          <?php endif;?>
           </td>
           <td><?php echo read_date($a_user['last_login'])?></td>
           <td class="text-center">
             <div class="btn-group">
                <a href="edit_user?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="confirmDelete(<?=$a_user['id']?>)">
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
        buttons:['copy', 'csv', 'excel', 'pdf', 'print']
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
                    title: '',
                    customize: function (win) {
                        // Add a logo and custom styling to the print output
                        $(win.document.body).prepend(`
                            <div style="text-align: center; margin-bottom: 20px;">
                                <img src="libs/images/logo.png" alt="Company Logo" style="width: 150px;">
                                <h2>ISLAND SEA FUEL</h2>
                                <h4>KANGWAYAN MADRIDEJOS CEBU</h4>
                                  <h4>All Users</h4>
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

    var dtable = $('#defaultTable').DataTable({
    });

    print.buttons().container()
    .appendTo('#printable_wrapper .col-md-6:eq(0)');

    dashprint.buttons().container()
    .appendTo('#dashprint_wrapper .col-md-6:eq(0)');
});


function confirmDelete(userId) {
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
                    url: 'delete_user.php', // Your PHP script to handle deletion
                    type: 'GET', // Use GET request
                    data: { id: userId }, // Send the product ID to the PHP script
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
