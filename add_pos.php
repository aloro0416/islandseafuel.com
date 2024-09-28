<?php
ob_start(); // Start output buffering

$page_title = 'POS';
 page_require_level(2);
include('includes/load.php');
include('layouts/header.php');

if (isset($_POST['add'])) {
    $date = date('Y-m-d');
    $product_id = $_GET['product'];
    $customer_id = $_POST['customer'];
    $liter = $_POST['liter'];
    $amount = $_POST['amount'];
    $payment = $_POST['payment'];
    
    $status = ($payment == 'Cash') ? 1 : 0;
    
    $sel = "SELECT * FROM products WHERE id = '$product_id'";
    $sel_res = $db->query($sel);
    $sel_row = mysqli_fetch_assoc($sel_res);

    if ($sel_row) {
        $avail = $sel_row['quantity'];
        $total_lit = $avail - $liter;

        $pro = "UPDATE products SET quantity = '$total_lit' WHERE id = '$product_id'";
        $pros = $db->query($pro);

        $sqls = "INSERT INTO pos (customer_id, product_id, liter, amount, status) VALUES ('$customer_id', '$product_id', '$liter', '$amount', '$status')";
        $result = $db->query($sqls);

        $salesss = "INSERT INTO sales (product_id, qty, price, date) VALUES ('$product_id', '$liter', '$amount', '$date')";
        $s_result = $db->query($salesss);

        if ($pros && $result && $s_result) {
            $alert_type = 'success';
            $alert_message = 'Added successfully.';
        } else {
            $alert_type = 'error';
            $alert_message = 'Added failed. Please try again.';
        }
    } else {
        $alert_type = 'error';
        $alert_message = 'Product not found.';
    }

    // Output the alert message and then redirect
    echo "<script>
            Swal.fire({
                icon: '$alert_type',
                title: '$alert_message',
                showConfirmButton: true
            }).then(function() {
                window.location.href = 'pos.php';
            });
          </script>";

    exit(); // Ensure no further code is executed after script
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>POS</span>
                </strong>
                <a href="pos.php?" class="btn btn-info pull-right">Back</a>
            </div>
            <div class="row" style="padding: 15px;">
                <div class="col-md-8">
                    <?php 
                    $sql = "SELECT * FROM products";
                    $res = $db->query($sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                        if ($row['quantity'] == 0) {
                            ?>
                                <div class="box">
                                    <div class="row">
                                        <?=$row['name']?>
                                    </div>
                                    <div class="row">
                                        <div class="pull-right">
                                        ₱<?=$row['sale_price']?>
                                        </div>
                                    </div>
                                    <div class="row text-center text-light bg-red">
                                        Out of stock
                                    </div>
                                </div>
                        <?php
                        } else {
                            ?>
                            <a href="?product=<?=$row['id']?>">
                                <div class="box">
                                    <div class="row">
                                        <?=$row['name']?>
                                    </div>
                                    <div class="row">
                                        <div class="pull-right">
                                        ₱<?=$row['sale_price']?>
                                        </div>
                                    </div>
                                    <div class="row text-center text-light bg-danger">
                                        <?=$row['quantity']?> liters left
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <?php 
                    if (isset($_GET['product'])) {
                        $sql = "SELECT * FROM products WHERE id='".$_GET['product']."'";
                        $res = $db->query($sql);
                        $pro = mysqli_fetch_assoc($res);
                        ?>
                        <h4>Selected Product: <span class="text-muted"><?=$pro['name']?></span> </h4>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control" name="customer" required>
                                    <?php 
                                    $cus = "SELECT * FROM customer";
                                    $res = $db->query($cus);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                        <option value="<?=$row['id']?>"><?=$row['firstname']." ". $row['lastname']?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="Random">Random</option>
                                </select>
                                <label for="liter" class="control-label">Liter</label>
                                <input type="number" onchange="calculateAmount(this.value)" min="0" class="form-control" name="liter" required>
                            
                                <label for="amount" class="control-label">Amount</label>
                                <input type="text" id="tot_amount" min="0" class="form-control" name="amount" readonly>
                            

                                <label for="payment">Payment</label>
                                <select class="form-control" name="payment" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Debt">Debt</option>
                                </select>
                            </div>
                            <button type="submit" name="add" class="btn btn-primary form-control">Add</button>
                        </form>
                        
                        <?php
                    } else {
                        ?>
                        <h4>Select a product</h4>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .row .col-md-8 {
        display: flex;  
        flex-wrap: wrap;
    }
    .box {
        width: 190px;
        height: 100px;
        background: red;
        color: black;
        margin-right: 10px;
    }
    .row .col-md-8 a {
        text-decoration: none;
    }
</style>

<script>
    function calculateAmount(val) {
        var tot_price = val * <?=$pro['sale_price']?>;
        var divobj = document.getElementById('tot_amount');
        divobj.value = tot_price;
    }
</script>

<?php include_once('layouts/footer.php'); ?>

<?php
ob_end_flush(); // Flush the output buffer
?>
