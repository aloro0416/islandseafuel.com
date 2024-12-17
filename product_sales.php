<?php
  $page_title = 'Product Sales';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
   @$pro_id = $_GET['pro'];

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <?php 
         $result = $db->query("SELECT SUM(price) AS total_sold FROM sales WHERE product_id = '$pro_id'");
         $total = mysqli_fetch_assoc($result);
         $sum = $total['total_sold'];
         ?>
        <h3 style="text-align: left;">Total Product Sales: <span style="text-decoration: underlined;">₱<?=$sum?></span></h3>
        <div class="dropdown">
            <span style="margin-right: 10px;">Select a product:</span>
            <button class="btn btn-primary dropdown-toggle" type="button" id="about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Products
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="about-us">
                <?php
                    $sql = "SELECT * FROM products";
                    $res = $db->query($sql);
                    while ($pro = mysqli_fetch_assoc($res)) { ?>
                    <li><a href="?pro=<?=$pro['id']?>"><?=$pro['name']?></a></li>
                    <?php } ?>
            </ul>
        </div>
        </div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Product Sales</span>
          </strong>
        </div>
        <div class="panel-body">
        <div class="data_table">
        <table id="printable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity sold</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
             </tr>
            </thead>
           <tbody>
            <?php 
             $prod = "SELECT * FROM sales INNER JOIN products ON products.id=sales.product_id WHERE sales.product_id='$pro_id'";
             $pres = $db->query($prod);
             $i = 1;
             while ($row = mysqli_fetch_assoc($pres)) {
             ?>
             <tr>
               <td class="text-center"><?=$i++?></td>
               <td><?=$row['name']?></td>
               <td class="text-center"><?=$row['qty']?></td>
               <td class="text-center"><?=$row['price']?></td>
               <td class="text-center"><?=date('M d, Y', strtotime($row['date']))?></td>
             </tr>
             <?php }?>
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
                                  <h4>Product Sales</h4>
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

</script>
