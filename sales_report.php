<?php
$page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Date Range</label>
                <div class="input-group">
                  <span class="input-group-addon"><strong>From</strong></span>
                  <input type="date" class=" form-control" id="start-date" name="start-date" placeholder="From">
                  <span class="input-group-addon"><strong>To</strong></span>
                  <input type="date" class=" form-control" id="end-date" name="end-date" placeholder="To">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>


<script>
const startDateInput = document.getElementById('start-date');
const endDateInput = document.getElementById('end-date');

startDateInput.addEventListener('change', function() {
    const selectedStartDate = new Date(startDateInput.value);
    
    // Set the minimum end date to the selected start date
    if (!isNaN(selectedStartDate)) {
        endDateInput.min = startDateInput.value; // Sets min attribute for end date
    } else {
        endDateInput.min = ''; // Clear if no valid start date is selected
    }
});
</script>
<?php include_once('layouts/footer.php'); ?>
