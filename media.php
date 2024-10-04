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
        $session->msg('s','photo has been uploaded.');
        redirect('media');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('media');
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
                <input type="file" name="file_upload" multiple="multiple" id="file-upload" />
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
                      <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                  </td>
                <td class="text-center">
                  <?php echo $media_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="delete_media?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
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

</script>
