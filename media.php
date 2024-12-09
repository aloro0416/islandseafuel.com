<?php
  $page_title = 'All Image';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php $media_files = find_all('media');?>
<?php
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $photo->upload($_FILES['file_upload']);
    if($photo->process_media()){
        $success = true;
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($success) && $success): ?>
        Swal.fire({
        icon: 'success',
        title: 'Photo has been uploaded',
        showConfirmButton: true,
        }).then(() => {
        window.location.href = 'media';
        })
        <?php endif; ?>
        });
        </script>
        <?php
    } else{
      $error = true;
      ?>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
      <?php if (isset($error) && $error): ?>
      Swal.fire({
      icon: 'error',
      title: join($photo->errors),
      showConfirmButton: true,
      }).then(() => {
      window.location.href = 'media';
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

      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>All Photos</span>
            <div class="pull-right">
              <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                <div class="custom-file-upload">
                <input type="file" name="file_upload" multiple="multiple" id="file-upload" class="form-control" />
                <label for="file-upload">Choose File</label>
              </div>
                 <button type="submit" name="submit" class="btn btn-default">Upload</button>
               </div>
              </div>
              <style>
                .custom-file-upload {
                  position: relative;
                  display: inline-block;
                }

                .custom-file-upload input[type="file"] {
                  position: absolute;
                  opacity: 0;
                  width: 100%;
                  height: 100%;
                  cursor: pointer;
                }

                .custom-file-upload label {
                  display: inline-block;
                  padding: 6px 12px;
                  cursor: pointer;
                  background-color: #007bff;
                  color: #fff;
                  border-radius: 4px;
                }

                .btn-upload {
                  display: inline-block;
                  padding: 6px 12px;
                  cursor: pointer;
                  background-color: #007bff;
                  color: #fff;
                  border: 1px solid #007bff;
                  border-radius: 4px;
                  text-align: center;
                  font-size: 14px;
                }

                .btn-upload:hover {
                  background-color: #0056b3;
                }

                .is-valid {
                    border-color: #28a745; /* Green */
                }

                .is-invalid {
                    border-color: #dc3545; /* Red */
                }

              </style>

             </form>
            </div>
          </div>
          <div class="panel-body">
           <div class="data_table">
                        <table id="dashprint" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Photo</th>
                  <th class="text-center">Photo Name</th>
                  <th class="text-center" style="width: 20%;">Photo Type</th>
                  <th class="text-center" style="width: 50px;">Actions</th>
                </tr>
              </thead>
                <tbody>
                <?php foreach ($media_files as $media_file): ?>
                <tr class="list-inline">
                 <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center">
                      <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" style="object-fit: cover;" />
                  </td>
                <td class="text-center">
                  <?php echo $media_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="confirmDelete(<?=$media_file['id']?>)">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
               </tr>
              <?php endforeach;?>
            </tbody>
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

function confirmDelete(mediaId) {
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
                    url: 'delete_media.php', // Your PHP script to handle deletion
                    type: 'GET', // Use GET request
                    data: { id: mediaId }, // Send the product ID to the PHP script
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


    document.getElementById('file-upload').addEventListener('change', function() {
    var fileInput = this;
    var files = fileInput.files;
    var isValid = true;
    var invalidFiles = [];
    var exceededFiles = [];

    // Loop through selected files and check the extension and size
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        var fileSize = file.size / 1024 / 1024; // Convert size to MB

        // Check if the file extension is valid
        if (!['png', 'jpg', 'jpeg'].includes(fileExtension)) {
            isValid = false;
            invalidFiles.push(file.name);
        }

        // Check if the file size exceeds 2MB
        if (fileSize > 2) {
            isValid = false;
            exceededFiles.push(file.name);
        }
    }

    // Add the is-valid or is-invalid class based on the validation result
    if (isValid) {
        fileInput.classList.remove('is-invalid');
        fileInput.classList.add('is-valid');
    } else {
        fileInput.classList.remove('is-valid');
        fileInput.classList.add('is-invalid');
        
        // Alert invalid file types and size exceeded files
        var errorMessages = [];
        if (invalidFiles.length > 0) {
            errorMessages.push('Invalid file types: ' + invalidFiles.join(', '));
        }
        if (exceededFiles.length > 0) {
            errorMessages.push('Files exceeded 2MB: ' + exceededFiles.join(', '));
        }

        alert(errorMessages.join('\n'));
    }
});
</script>
