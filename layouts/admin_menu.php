<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<nav class="sidebar navbar navbar-expand-md navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="admin">
          <i class="glyphicon glyphicon-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pos">
          <i class="glyphicon glyphicon-indent-left"></i>
          <span>POS</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#" data-toggle="collapse" data-target="#productsMenu">
          <i class="glyphicon glyphicon-th-large"></i>
          <span>Products</span>
        </a>
        <div id="productsMenu" class="collapse">
          <ul class="nav flex-column ml-3">
            <li class="nav-item"><a class="nav-link" href="product">Manage Products</a></li>
            <li class="nav-item"><a class="nav-link" href="add_product">Add Products</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#" data-toggle="collapse" data-target="#salesMenu">
          <i class="glyphicon glyphicon-credit-card"></i>
          <span>Sales</span>
        </a>
        <div id="salesMenu" class="collapse">
          <ul class="nav flex-column ml-3">
            <li class="nav-item"><a class="nav-link" href="sales">Manage Sales</a></li>
            <li class="nav-item"><a class="nav-link" href="add_sale">Add Sale</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#" data-toggle="collapse" data-target="#salesReportMenu">
          <i class="glyphicon glyphicon-duplicate"></i>
          <span>Sales Report</span>
        </a>
        <div id="salesReportMenu" class="collapse">
          <ul class="nav flex-column ml-3">
            <li class="nav-item"><a class="nav-link" href="sales_report">Sales by Dates</a></li>
            <li class="nav-item"><a class="nav-link" href="monthly_sales">Monthly Sales</a></li>
            <li class="nav-item"><a class="nav-link" href="daily_sales">Daily Sales</a></li>
            <li class="nav-item"><a class="nav-link" href="product_sales">Product Sales</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categorie">
          <i class="glyphicon glyphicon-indent-left"></i>
          <span>Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="media">
          <i class="glyphicon glyphicon-picture"></i>
          <span>Media Files</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#" data-toggle="collapse" data-target="#userMenu">
          <i class="glyphicon glyphicon-user"></i>
          <span>User Management</span>
        </a>
        <div id="userMenu" class="collapse">
          <ul class="nav flex-column ml-3">
            <li class="nav-item"><a class="nav-link" href="group">Manage Groups</a></li>
            <li class="nav-item"><a class="nav-link" href="users">Manage Users</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px; margin-top: 50px;">
      </li>
    </ul>
  </div>
</nav>
