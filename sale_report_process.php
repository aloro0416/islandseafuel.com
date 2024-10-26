<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    $start_date   = remove_junk($db->escape($_POST['start-date']));
    $end_date     = remove_junk($db->escape($_POST['end-date']));
    $startDate = date("Y-m-d", strtotime($start_date));
    $endDate    = date("Y-m-d", strtotime($end_date));

    $check = "SELECT * FROM sales WHERE date BETWEEN '{$start_date}' AND '{$end_date}'";
    $c_res = $db->query($check);
    if ($db->num_rows($c_res) > 0) {
        $results = find_sale_by_dates($start_date,$end_date);
    }else {
      $session->msg("d", 'No sales report has found!');
      redirect('sales_report', false);
    }

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report', false);
  }
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Default Page Title</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
      #print{
        display:none;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
       border-raduis: 10px;
      
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px dashed #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }table thead tr th,table tfoot tr td{
       background-color: #337ab7;
       color: white;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($results): ?>
    <div class="page-break">
       <div class="sale-head bg-primary text-light text-center" style="padding: 10px;">
           <img src="uploads/logo.png" style="height: 100px; object-fit: cover;">
           <h1>Island Sea Management System - Sales Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> TILL DATE <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Product Title</th>
              <th>Buying Price</th>
              <th>Selling Price</th>
              <th>Total Qty</th>
              <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class=""><?php echo remove_junk($result['date']);?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right"><?php echo remove_junk($result['buy_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['sale_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_saleing_price']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Grand Total</td>
           <td> ₱
           <?php echo number_format(total_price($results)[0], 2);?>
          </td>
         </tr>
         <!-- <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Profit</td>
           <td> <?php 
           echo number_format(abs(total_price($results)[1]), 2);?></td>
         </tr> -->
        </tfoot>
      </table>
      <div class="text-right" style="margin-bottom: 20px;">
      <button onclick="window.print()" id="print" class="btn btn-primary btn-lg"> <i class="fa-solid fa-print"></i> Print</button>
      </div>
    </div>
  <?php
    else:
        $session->msg("d", "Sorry no sales has been found. ");
        redirect('sales_report', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
