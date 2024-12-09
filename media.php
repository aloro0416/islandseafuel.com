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
      $error_message = join($photo->errors);
      $error = true;
      ?>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
      <?php if (isset($error) && $error): ?>
      Swal.fire({
      icon: 'error',
      title: '<?php echo addslashes($error_message); ?>',
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
                <input type="file" name="file_upload" multiple="multiple" id="file-upload" onchange="validateFile(this)" />
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
</script>

<script>
        function validateFile(input) {
            const allowedExtensions = ['.png', '.jpg', '.jpeg'];
            const deniedExtensions = ['.php', '.html'];
            const files = input.files;
            let valid = true;
            let errorMessage = "";

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileName = file.name;
                const fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();

                // Check if the file extension is allowed
                if (!allowedExtensions.includes(fileExtension)) {
                    valid = false;
                    errorMessage = `Only PNG, JPG, and JPEG files are allowed.`;
                    break;
                }

                // Check if the file contains any disallowed extension like .php or .html in the name
                for (let j = 0; j < deniedExtensions.length; j++) {
                    if (fileName.toLowerCase().includes(deniedExtensions[j])) {
                        valid = false;
                        errorMessage = `File names containing ${deniedExtensions[j]} are not allowed.`;
                        break;
                    }
                }
            }

            if (!valid) {
                // Use SweetAlert to show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: errorMessage,
                    confirmButtonText: 'Ok'
                });

                input.value = '';  // Clear the selected file(s)
            }
        }
    </script>