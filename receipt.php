<?php
ob_start(); // Start output buffering
$page_title = 'POS';
include('includes/load.php');
 page_require_level(2);

$receipt_id = $_GET['receipt_id'];
$customer_id = $_GET['cus_id'];

$joins = "SELECT * FROM pos INNER JOIN customer ON pos.customer_id=customer.id WHERE receipt_id='$receipt_id'";
$j_res = $db->query($joins);
$j_row = mysqli_fetch_assoc($j_res);

$pos = "SELECT * FROM pos WHERE receipt_id='$receipt_id'";
$pos_res = $db->query($pos);
$pos = mysqli_fetch_assoc($pos_res);

$prod = "SELECT * FROM products WHERE id ='".$j_row['product_id']."'";
$p_res = $db->query($prod);
$p_row = mysqli_fetch_assoc($p_res);

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<link rel="stylesheet" href="libs/css/main.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><div class="container">

<div class="row d-flex- justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Invoice #<?=$j_row['receipt_id']?> <span class="badge bg-success font-size-12 ms-2">
                            <?php 
                            if ($pos['status'] == 1) {
                                echo "Paid";
                            }else{
                                echo "Unpaid";
                            }
                            ?>
                        </span></h4>
                        <div class="mb-4">
                           <h2 class="mb-1 text-muted"><img src="uploads/logo.png" alt="logo" class="img-logo"></h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">IslandSea Management System</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i>islandsea2001@gmail.com</p>
                            <p><i class="uil uil-phone me-1"></i> +63 905 168 2551</p>
                        </div>
                    </div>
            
                     <span class="text-center text-muted">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </span>
                    

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Billed To:</h5>
                                <h5 class="font-size-15 mb-2"><?=$j_row['firstname']." ".$j_row['lastname']?></h5>
                                <p class="mb-1"><?=$j_row['customer_type']?> Customer</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                    <p>#<?=$j_row['receipt_id']?></p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                    <p><?=date('M d, Y h:i a',strtotime($j_row['date']))?></p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    
                    <div class="py-2">
                        <h5 class="font-size-15">Order Summary</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr>
                                        <th scope="row"><?=$pos['id']?></th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1"><?=$p_row['name']?></h5>
                                                <p class="text-muted mb-0"></p>
                                            </div>
                                        </td>
                                        <td>₱ <?=$p_row['sale_price']?></td>
                                        <td><?=$j_row['liter']?></td>
                                        <td class="text-end">₱ <?=$j_row['amount']?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                        <td class="border-0 text-end"><h4 class="m-0 fw-semibold">₱ <?=$j_row['amount']?></h4></td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="d-flex justify-content-between">
                                <a href="pos.php" class="btn btn-info text-light">Back to POS</a>
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>

<style>
body{
    margin-top:20px;
    background-color:#eee;
}

.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: 1rem;
    margin-bottom: 30px;
}
.img-logo{
    height: 100px;
    object-fit: cover;
}
</style>
