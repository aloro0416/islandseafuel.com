<?php
  $page_title = 'POS_SALE';
  require_once('includes/load.php');
   // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php include_once('layouts/header.php'); ?>


<div class="row">
   <?php 
        if (isset($_GET['proc'])) {
            if ($_GET['proc'] == 'customer') {
                ?>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Name </th>
                            <th class="text-center" style="width: 30%;"> Customer Type</th>
                            <th class="text-center" style="width: 100px;"> Actions </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $loop = "SELECT * FROM customer";
                            $result = $db->query($loop);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=$row['firstname']." ".substr($row['middlename'], 0 ,1)." ". $row['lastname']?></td>
                                <td><?=$row['customer_type']?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="add_customer?update=<?=$row['id']?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_customer?delete=<?=$row['id']?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                        <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <a href="add_customer" class="btn btn-primary">Add Customer</a>
                    </div>
                </div>
                
                <?php
            }
        }else{
            ?>
               <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Customer name </th>
                            <th class="text-center" style="width: 15%;"> Product</th>
                            <th class="text-center" style="width: 5%;"> Liter</th>
                            <th class="text-center" style="width: 10%;"> Amount </th>
                            <th class="text-center" style="width: 15%;"> Payment type </th>
                            <th class="text-center" style="width: 15%;"> Payment status </th>
                            <th class="text-center" style="width: 100px;"> Action </th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM pos";
                        $res = $db->query($sql);
                        $e = 1;
                        while ($row = mysqli_fetch_assoc($res)) {
                            $cus_id = $row['customer_id'];
                            $pro_id = $row['product_id'];
                            $cus = "SELECT * FROM customer WHERE id = '$cus_id'";
                            $cus_res = $db->query($cus);
                            $cus_row = mysqli_fetch_assoc($cus_res);

                            $pro = "SELECT * FROM products WHERE id = '$pro_id'";
                            $pro_res = $db->query($pro);
                            $pro_row = mysqli_fetch_assoc($pro_res);
                        ?>
                            <tr>
                                <td class="text-center"><?=$e++?></td>
                                <td>
                                    <?php 
                                    if ($row['customer_id'] == 0) {
                                        echo "Random";
                                    }else{
                                        ?>
                                        <?=$cus_row['firstname'] ." ". $cus_row['lastname']?>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="text-center"><?=$pro_row['name']?></td>
                                <td class="text-center"><?=$row['liter']?></td>
                                <td class="text-center">₱<?=$row['amount']?></td>
                                <td class="text-center">
                                    <?php 
                                    if ($row['status'] == 1) {
                                       echo "Cash";
                                    }elseif($row['status'] == 0){
                                       echo "Debt";
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                    if ($row['status'] == 1) {
                                       echo "Paid";
                                    }elseif($row['status'] == 0){
                                       echo "Unpaid";
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_pos?update=<?=$row['id']?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_pos?delete=<?=$row['id']?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                        <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                    </table>
                    <div class="pull-right">
                        <a href="add_pos" class="btn btn-primary">Add</a>
                    </div>
                </div>
            <?php
        }
        ?>

</div>

<?php include_once('layouts/footer.php'); ?>
