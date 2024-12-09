<?php
  $page_title = 'All categories';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_categories = find_all('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO categories (name)";
      $sql .= " VALUES ('{$cat_name}')";
      if($db->query($sql)){
        $success = true;
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($success) && $success): ?>
        Swal.fire({
        icon: 'success',
        title: 'Successfully Added New Category',
        showConfirmButton: true,
        }).then(() => {
        window.location.href = 'categorie';
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
        title: 'Sorry Failed to insert',
        showConfirmButton: true,
        }).then(() => {
        window.location.href = 'categorie';
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
        window.location.href = 'categorie';
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
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Category</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="categorie.php">
            <div class="form-group">
                <input type="text" class="form-control" id="categorie_name" name="categorie-name" placeholder="Category Name">
            </div>
            <button type="submit" name="add_cat" class="btn btn-primary">Add Category</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Categories</span>
       </strong>
      </div>
        <div class="panel-body">
         <div class="data_table">
            <table id="dashprint" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Categories</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_categories as $cat):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_categorie?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="confirmDelete(<?=$cat['id']?>)">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
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
        buttons:['copy', 'csv', 'excel', 'pdf', 'print']
    });

    var dtable = $('#defaultTable').DataTable({
    });

    print.buttons().container()
    .appendTo('#printable_wrapper .col-md-6:eq(0)');

    dashprint.buttons().container()
    .appendTo('#dashprint_wrapper .col-md-6:eq(0)');

 
});


document.getElementById('categorie_name').addEventListener('input', function () {
        var categorie_name = this.value.trim();
        
        var dangerousCharsPattern = /[<>\"\']/;
        
        if (categorie_name === "") {
            this.setCustomValidity('Categorie title cannot be empty or just spaces.');
        } else if (this.value !== categorie_name) {
            this.setCustomValidity('Categorie title cannot start with a space.');
        } else if (dangerousCharsPattern.test(categorie_name)) {
            this.setCustomValidity('Categorie title cannot contain HTML special characters like <, >, ", \'.');
        } else {
            this.setCustomValidity('');
        }
        
        var isValid = categorie_name !== "" && this.value === categorie_name && !dangerousCharsPattern.test(categorie_name);
        this.classList.toggle('is-invalid', !isValid);
    });


    function confirmDelete(catId) {
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
                    url: 'delete_categorie.php', // Your PHP script to handle deletion
                    type: 'GET', // Use GET request
                    data: { id: catId }, // Send the product ID to the PHP script
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
