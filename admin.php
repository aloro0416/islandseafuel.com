<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5')
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-4">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <a href="users" style="color:black;">
		<div class="col-md-4">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i> 
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_user['total']; ?> </h2>
          <p class="text-muted">Users</p>
        </div>
       </div>
    </div>
	  </a>
	
	
	
	<a href="product" style="color:black;">
    <div class="col-md-4">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
          <p class="text-muted">Products</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="sales" style="color:black;">
    <div class="col-md-4">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
         <i class="fa fa-peso-sign"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_sale['total']; ?></h2>
          <p class="text-muted">Sales</p>
        </div>
       </div>
    </div>
	</a>
</div>
<?php 
        $sales = "SELECT SUM(price) as total_sales FROM sales";
        $result = $db->query($sales);
        $row = mysqli_fetch_assoc($result);
        $total_price = $row['total_sales'];

        $saless = "SELECT SUM(amount) as total_amount FROM pos";
        $resultss = $db->query($saless);
        $rows = mysqli_fetch_assoc($resultss);
        $total_sales = $rows['total_amount'];

        $total_sales = $total_price + $total_sales;

        $buy = "SELECT * FROM products";
        $b_res = $db->query($buy);
        while ($b = mysqli_fetch_assoc($b_res)) {
          $quantity = $b['quantity'];
          $price = $b['sale_price'];
	  $pro_id= $b['id'];

          $sum_total = $quantity * $price;

          @$total_bought = $total_bought + $sum_total;
          $product_id = 14; // Replace with actual product ID

        $monthly_product_sales = [];
        foreach (['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'] as $month_num => $month_name) {
            $sql = "SELECT SUM(price) as total FROM sales WHERE MONTH(date) = $month_num AND product_id = '$product_id'";
            $result = $db->query($sql);
            $data = mysqli_fetch_assoc($result);
            $monthly_product_sales[] = (int)$data['total'];
        }
        $product_sales_json = json_encode($monthly_product_sales);

        $product_id_2 = 15; // Replace with actual product ID for the second line

        $monthly_product_sales_2 = [];
        foreach (['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'] as $month_num => $month_name) {
            $sql = "SELECT SUM(price) as total FROM sales WHERE MONTH(date) = $month_num AND product_id = '$product_id_2'";
            $result = $db->query($sql);
            $data = mysqli_fetch_assoc($result);
            $monthly_product_sales_2[] = (int)$data['total'];
        }
        $product_sales_json_2 = json_encode($monthly_product_sales_2);

		
	// START COPY HERE!
        $product_id_3 = 16; // Replace with actual product ID for the second line

        $monthly_product_sales_3 = [];
        foreach (['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'] as $month_num => $month_name) {
            $sql = "SELECT SUM(price) as total FROM sales WHERE MONTH(date) = $month_num AND product_id = '$product_id_3'";
            $result = $db->query($sql);
            $data = mysqli_fetch_assoc($result);
            $monthly_product_sales_3[] = (int)$data['total'];
        }
        $product_sales_json_3 = json_encode($monthly_product_sales_3);
	// END COPY!
		

       // PASTE IT HERE
	

        }
       ?>
        <?php 
        $jan = "SELECT SUM(price) as jan FROM sales WHERE MONTH(date) = 1";
        $j_res = $db->query($jan);
        $j = mysqli_fetch_assoc($j_res);
        $january = (int) $j['jan'];

        $feb = "SELECT SUM(price) as feb FROM sales WHERE MONTH(date) = 2";
        $j_res = $db->query($feb);
        $j = mysqli_fetch_assoc($j_res);
        $febuary = (int) $j['feb'];

        $mar = "SELECT SUM(price) as mar FROM sales WHERE MONTH(date) = 3";
        $j_res = $db->query($mar);
        $j = mysqli_fetch_assoc($j_res);
        $march = (int) $j['mar'];

        $apr = "SELECT SUM(price) as apr FROM sales WHERE MONTH(date) = 4";
        $j_res = $db->query($apr);
        $j = mysqli_fetch_assoc($j_res);
        $april = (int) $j['apr'];

        $may = "SELECT SUM(price) as may FROM sales WHERE MONTH(date) = 5";
        $j_res = $db->query($may);
        $j = mysqli_fetch_assoc($j_res);
        $may = (int) $j['may'];

        $june = "SELECT SUM(price) as june FROM sales WHERE MONTH(date) = 6";
        $j_res = $db->query($june);
        $j = mysqli_fetch_assoc($j_res);
        $june = (int) $j['june'];

        $july = "SELECT SUM(price) as july FROM sales WHERE MONTH(date) = 7";
        $j_res = $db->query($july);
        $j = mysqli_fetch_assoc($j_res);
        $july = (int) $j['july'];

        $aug = "SELECT SUM(price) as aug FROM sales WHERE MONTH(date) = 8";
        $j_res = $db->query($aug);
        $j = mysqli_fetch_assoc($j_res);
        $aug = (int) $j['aug'];

        $sept = "SELECT SUM(price) as sept FROM sales WHERE MONTH(date) = 9";
        $j_res = $db->query($sept);
        $j = mysqli_fetch_assoc($j_res);
        $sept = (int) $j['sept'];

        $oct = "SELECT SUM(price) as oct FROM sales WHERE MONTH(date) = 10";
        $j_res = $db->query($oct);
        $j = mysqli_fetch_assoc($j_res);
        $oct = (int) $j['oct'];

        $nov = "SELECT SUM(price) as nov FROM sales WHERE MONTH(date) = 11";
        $j_res = $db->query($nov);
        $j = mysqli_fetch_assoc($j_res);
        $nov = (int) $j['nov'];

        $dec = "SELECT SUM(price) as dece FROM sales WHERE MONTH(date) = 12";
        $j_res = $db->query($dec);
        $j = mysqli_fetch_assoc($j_res);
        $dec = (int) $j['dece'];
        ?>


<div class="row">
  <!-- Line Chart -->
  <div class="col-md-8">
    <div class="panel panel-box clearfix" style="padding: 10px;">
      <div id="lineChart"></div>
    </div>
    <script>
      var options = {
        series: [
          {
            name: "Total Sales",
            data: [<?=$january?>, <?=$febuary?>, <?=$march?>, <?=$april?>, <?=$may?>, <?=$june?>, <?=$july?>, <?=$aug?>, <?=$sept?>, <?=$oct?>, <?=$nov?>, <?=$dec?>]
          },
          {
            name: "Premium",
            data: <?= $product_sales_json ?>
          },
          {
            name: "Diesel",
            data: <?= $product_sales_json_2 ?>
          },
          {
            name: "Super93",
            data: <?= $product_sales_json_3 ?>
          }
        ],
        chart: {
          height: 350,
          type: 'line',
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        title: {
          text: 'Sales by Month',
          align: 'left'
        },
        stroke: {
          curve: 'smooth'
        },
      };

      var chart2 = new ApexCharts(document.querySelector("#lineChart"), options);
      chart2.render();
    </script>
  </div>

  <!-- Pie Chart -->
  <div class="col-md-4">
    <div class="panel panel-box clearfix" style="padding: 10px; text-align: center; position: relative;">
      
      <!-- Title Above the Donut Chart -->
      <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">Latest Sales Distribution</h3>
      
      <!-- Pie Chart -->
      <div id="pieChart" style="position: relative;"></div>

      <!-- Centered Icon -->
      <div id="centerIcon" style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 40px;
        color: #5A57FF;">
        <i class="fa fa-shopping-cart"></i> <!-- FontAwesome Icon -->
      </div>

      <!-- Product Labels Below Pie Chart -->
      <div id="pieChartLabels" style="margin-top: 20px; text-align: center; font-size: 12px; font-weight: bold;"></div>
    </div>
    <script>
      var recentSales = <?php echo json_encode($recent_sales); ?>;

      // Summarize sales data
      var salesSummary = {};
      recentSales.forEach(function (sale) {
        var productName = sale.name;
        var saleAmount = parseFloat(sale.price);

        if (salesSummary[productName]) {
          salesSummary[productName] += saleAmount;
        } else {
          salesSummary[productName] = saleAmount;
        }
      });

      // Prepare the data for the pie chart
      var chartData = [];
      var chartLabels = [];
      for (var product in salesSummary) {
        chartLabels.push(product);
        chartData.push(salesSummary[product]);
      }

      // Generate colors dynamically based on the number of products
      function generateColors(count) {
        var colors = [];
        var colorPalette = ['#5A57FF', '#0DC27B', '#E3E5E5', '#FF6F61', '#F7B731', '#FF6347', '#2D9CDB', '#56CCF2', '#BB6BD9', '#FDCB82'];
        for (var i = 0; i < count; i++) {
          colors.push(colorPalette[i % colorPalette.length]);
        }
        return colors;
      }

      var colors = generateColors(chartLabels.length); // Get the color palette for the number of products

      // Pie chart options
      var options = {
        series: chartData,
        chart: {
          height: 250, // Smaller height to match design
          type: 'donut',
        },
        labels: chartLabels,
        legend: { show: false }, // Disable default legend
        colors: colors, // Use dynamically generated colors
        dataLabels: {
          enabled: false, // Disable percentage in the donut
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "₱ " + val.toFixed(2); // Show values in currency
            }
          }
        },
      };

      // Render the pie chart
      var chart = new ApexCharts(document.querySelector("#pieChart"), options);
      chart.render();

      // Render product labels below the pie chart
      var labelsContainer = document.querySelector("#pieChartLabels");
      chartLabels.forEach(function (label, index) {
        var color = options.colors[index % options.colors.length]; // Ensure color matches
        var percentage = ((chartData[index] / chartData.reduce((a, b) => a + b)) * 100).toFixed(1);

        // Add the legend-like labels
        var labelDiv = document.createElement("div");
        labelDiv.style.margin = "5px 0";
        labelDiv.innerHTML = `
          <span style="display: inline-block; width: 12px; height: 12px; background-color: ${color}; margin-right: 5px; border-radius: 50%;"></span>
          ${label}: <strong>${percentage}%</strong>
        `;
        labelsContainer.appendChild(labelDiv);
      });
    </script>
    <!-- FontAwesome for Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </div>
</div>




  <div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
      <?php foreach ($recent_products as  $recent_product): ?>
            <a class="list-group-item clearfix" href="edit_product?id=<?php echo    (int)$recent_product['id'];?>">
                <h4 class="list-group-item-heading">
                 <?php if($recent_product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" style="object-fit: cover;" />
                <?php endif;?>
                <?php echo remove_junk(first_character($recent_product['name']));?>
                  <span class="label label-warning pull-right">
                 <?php echo (int)$recent_product['sale_price']; ?>
                  </span>
                </h4>
                <span class="list-group-item-text pull-right">
                <?php echo remove_junk(first_character($recent_product['categorie'])); ?>
              </span>
          </a>
      <?php endforeach; ?>
    </div>
  </div>
 </div>
  </div>
        <div class="col-md-8">
          <div class="panel panel-box clearfix" style="padding: 10px;">
            <div id="chart"></div>
            <script>
              var options = {
                series: [{
                name: 'Amount',
                data: [<?=$total_bought?>, <?=$total_sales?>]
              }],
                chart: {
                height: 350,
                type: 'bar',
              },
              plotOptions: {
                bar: {
                  columnWidth: '45%',
                  borderRadius: 10,
                  dataLabels: {
                    position: 'top', // top, center, bottom
                  },
                }
              },
              dataLabels: {
                enabled: true,
                formatter: function (val) {
                  return "₱ " + val;
                },
                offsetY: -20,
                style: {
                  fontSize: '12px',
                  colors: ["#304758"]
                }
              },
              
              xaxis: {
                categories: ["Available Gas", "Sales"],
                position: 'top',
                axisBorder: {
                  show: false
                },
                axisTicks: {
                  show: false
                },
                crosshairs: {
                  fill: {
                    type: 'gradient',
                    gradient: {
                      colorFrom: '#D8E3F0',
                      colorTo: '#BED1E6',
                      stops: [0, 100],
                      opacityFrom: 0.4,
                      opacityTo: 0.5,
                    }
                  }
                },
                tooltip: {
                  enabled: true,
                }
              },
              
              yaxis: {
                axisBorder: {
                  show: false
                },
                axisTicks: {
                  show: false,
                },
                labels: {
                  show: false,
                  formatter: function (val) {
                    return "₱ " + val;
                  }
                }
              
              },
              title: {
                text: 'OVER ALL SALES',
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                  color: '#444'
                }
              }
              };

              var chart = new ApexCharts(document.querySelector("#chart"), options);
              chart.render();
            </script>
            </div>
          </div>
          
        </div>
        
    </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Highest Selling Products</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
              <th>Title</th>
              <th>Total Sold</th>
              <th>Total Quantity</th>
            <tr>
            </thead>
            <tbody>
              <?php foreach ($products_sold as  $product_sold): ?>
                <tr>
                  <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                  <td><?php echo (int)$product_sold['totalSold']; ?></td>
                  <td><?php echo (int)$product_sold['totalQty']; ?></td>
                </tr>
              <?php endforeach; ?>
            <tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>
              <span class="glyphicon glyphicon-th"></span>
              <span>LATEST SALES</span>
            </strong>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Product Name</th>
            <th>Date</th>
            <th>Total Sale</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recent_sales as  $recent_sale): ?>
          <tr>
            <td class="text-center"><?php echo count_id();?></td>
            <td>
              <a href="edit_sale?id=<?php echo (int)$recent_sale['id']; ?>">
              <?php echo remove_junk(first_character($recent_sale['name'])); ?>
            </a>
            </td>
            <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
            <td><?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
          </tr>

        <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
    </div>
    
  </div>
 </div>
  <div class="row">

  </div>



<?php include_once('layouts/footer.php'); ?>
