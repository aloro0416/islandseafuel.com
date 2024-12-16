<?php
  $page_title = 'POS';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>
                <?php
                if (isset($_GET['proc'])) {
                    echo $_GET['proc'];
                }else{
                    echo "POS";
                }
                ?>
            </span>
          </strong>
          <div class="pull-right">
            <a href="?proc=customer" class="btn btn-primary">Customer</a>
            <a href="?" class="btn btn-primary">POS</a>
          </div>
        </div>
        <?php 
        if (isset($_GET['proc'])) {
            if ($_GET['proc'] == 'customer') {
                ?>
                <div class="panel-body">
                    <div class="data_table">
                        <table id="printable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th> Name </th>
                                <th class="text-center" style="width: 30%;"> Customer Type</th>
                                <th class="text-center" style="width: 100px;"> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $loop = "SELECT * FROM customer";
                                $result = $db->query($loop);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=$row['firstname']." ".substr($row['middlename'], 0 ,1)." ". $row['lastname']?></td>
                                    <td><?=$row['customer_type']?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="add_customer?update=<?=$row['id']?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove" onclick="confirmDelete(<?=$row['id']?>)">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <a href="add_customer" class="btn btn-primary">Add Customer</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }else{
            ?>
               <div class="panel-body">
                    <div class="data_table">
                        <table id="dashprint" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th> Customer name </th>
                                    <th class="text-center" style="width: 15%;"> Product</th>
                                    <th class="text-center" style="width: 5%;"> Liter</th>
                                    <th class="text-center" style="width: 10%;"> Amount </th>
                                    <th class="text-center" style="width: 15%;"> Payment type </th>
                                    <th class="text-center" style="width: 15%;"> Payment status </th>
                                    <th class="text-center"> Receipt Code </th>
                                    <th class="text-center" style="width: 100px;"> Action </th>
                                </tr>
                                </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM pos";
                                $res = $db->query($sql);
                                $e = 1;
                                while ($row = mysqli_fetch_assoc($res)) {
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
                                        <td class="text-center"><?=$e++?></td>
                                        <td>
                                            <?php 
                                            if ($row['customer_id'] == 0) {
                                                echo "Random";
                                            }else{
                                                ?>
                                                <?=$cus_row['firstname'] ." ". $cus_row['lastname']?>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?=$pro_row['name']?></td>
                                        <td class="text-center"><?=$row['liter']?></td>
                                        <td class="text-center">₱<?=$row['amount']?></td>
                                        <td class="text-center">
                                            <?php 
                                            if ($row['status'] == 1) {
                                            echo "Cash";
                                            }elseif($row['status'] == 0){
                                            echo "Debt";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                            if ($row['status'] == 1) {
                                            echo "Paid";
                                            }elseif($row['status'] == 0){
                                            echo "Unpaid";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?=$row['receipt_id']?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="edit_pos?update=<?=$row['id']?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove" onclick="confirmposDelete(<?=$row['id']?>)">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <a href="add_pos" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                </div>
            <?php
        }
        ?>
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
                                <h4>KANGWAYAN MADRIDEJOS CEBU</h4>
                                <h4>${pageTitle}</h4>
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
                                <h4>KANGWAYAN MADRIDEJOS CEBU</h4>
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

</script>

<script>
    function confirmDelete(customerId) {
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
                // Perform AJAX request to delete customer
                $.ajax({
                    url: 'delete_customer.php', // Your PHP script for deletion
                    type: 'GET', // Use GET request
                    data: { delete: customerId }, // Send the customer ID
                    success: function(response) {
                        // If deletion is successful, show success alert
                        Swal.fire(
                            'Deleted!',
                            'The customer has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to update the list
                        });
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

    function confirmposDelete(customerId) {
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
                // Perform AJAX request to delete customer
                $.ajax({
                    url: 'delete_pos.php', // Your PHP script for deletion
                    type: 'GET', // Use GET request
                    data: { delete: customerId }, // Send the customer ID
                    success: function(response) {
                        // If deletion is successful, show success alert
                        Swal.fire(
                            'Deleted!',
                            'The customer has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to update the list
                        });
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
