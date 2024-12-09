<?php
  $page_title = 'Edit categorie';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $categorie = find_by_id('categories',(int)$_GET['id']);
  if(!$categorie){
    $missing = true;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    <?php if (isset($missing) && $missing): ?>
    Swal.fire({
    icon: 'error',
    title: 'Missing categorie id',
    showConfirmButton: true,
    }).then(() => {
    window.location.href = 'categorie';
    })
    <?php endif; ?>
    });
    </script>
    <?php
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));
  if(empty($errors)){
        $sql = "UPDATE categories SET name='{$cat_name}'";
       $sql .= " WHERE id='{$categorie['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $success = true;
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($success) && $success): ?>
        Swal.fire({
        icon: 'success',
        title: 'Successfully updated Categorie',
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
        title: 'Sorry! Failed to Update',
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
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editing <?php echo remove_junk(ucfirst($categorie['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_categorie.php?id=<?php echo (int)$categorie['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" id="categorie_name" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>">
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Update categorie</button>
       </form>
       </div>
     </div>
   </div>
</div>

<script>
  document.getElementById('categorie_name').addEventListener('input', function () {
        var categorie_name = this.value.trim();
        
        var dangerousCharsPattern = /[<>\"\']/;
        
        if (categorie_name === "") {
            this.setCustomValidity('Categori title cannot be empty or just spaces.');
        } else if (this.value !== categorie_name) {
            this.setCustomValidity('Categori title cannot start with a space.');
        } else if (dangerousCharsPattern.test(categorie_name)) {
            this.setCustomValidity('Categori title cannot contain HTML special characters like <, >, ", \'.');
        } else {
            this.setCustomValidity('');
        }
        
        var isValid = categorie_name !== "" && this.value === categorie_name && !dangerousCharsPattern.test(categorie_name);
        this.classList.toggle('is-invalid', !isValid);
    });
</script>


<?php include_once('layouts/footer.php'); ?>
