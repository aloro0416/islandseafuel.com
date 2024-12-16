<style>
  /* Sidebar Styling */
.sidebar {
  width: 250px;
  background-color: #2c3e50;
  position: fixed;
  top: 0;
  left: 0;
  padding-top: 20px;
  color: #ecf0f1;
  transition: width 0.3s;
  height: 100%;
}

.sidebar a {
  display: block;
  padding: 15px;
  text-decoration: none;
  color: #ecf0f1;
  font-size: 16px;
  transition: background-color 0.3s;
}

.sidebar a:hover {
  background-color: #34495e;
}

.sidebar .submenu-toggle {
  cursor: pointer;
}

/* Hide submenu by default */
.sidebar .submenu {
  display: none;
  padding-left: 20px;
}

.sidebar .submenu li {
  margin: 5px 0;
}

.sidebar .submenu-toggle.active:after {
  content: " ▲";
}

.sidebar .submenu-toggle:after {
  content: " ▼";
}

.sidebar .submenu-toggle.active + .submenu {
  display: block;
}

/* Mobile Sidebar: Collapsed View */
@media (max-width: 768px) {
  .sidebar {
    width: 60px;
    transition: width 0.3s;
  }

  .sidebar a span {
    display: none;
  }

  .sidebar .submenu {
    position: absolute;
    top: 0;
    left: 60px;
    background-color: #34495e;
    width: 200px;
    display: none;
  }

  .sidebar .submenu li {
    padding-left: 20px;
  }

  .sidebar .submenu-toggle.active + .submenu {
    display: block;
  }

  /* Hamburger Menu (mobile) */
  .menu-toggle {
    display: block;
    position: absolute;
    top: 20px;
    left: 20px;
    cursor: pointer;
  }

  .menu-toggle span {
    background-color: #ecf0f1;
    display: block;
    height: 4px;
    width: 25px;
    margin: 5px 0;
  }

  .sidebar .logo {
    display: none;
  }

  .sidebar.active {
    width: 250px;
  }

  .sidebar.active .logo {
    display: block;
    text-align: center;
    margin-top: 20px;
  }

  /* Display menu with icons only */
  .sidebar.active a span {
    display: inline-block;
  }

  .sidebar .submenu {
    position: relative;
  }
}

</style>
<nav class="sidebar">
  <button class="menu-toggle">
    <span></span>
    <span></span>
    <span></span>
  </button>
  <ul>
    <li>
      <a href="admin">
        <i class="glyphicon glyphicon-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="pos">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>POS</span>
      </a>
    </li>
    <li class="submenu">
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Products</span>
      </a>
      <ul class="nav submenu">
        <li><a href="product">Manage Products</a></li>
        <li><a href="add_product">Add Products</a></li>
      </ul>
    </li>
    <li class="submenu">
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-credit-card"></i>
        <span>Sales</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales">Manage Sales</a></li>
        <li><a href="add_sale">Add Sale</a></li>
      </ul>
    </li>
    <li class="submenu">
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-duplicate"></i>
        <span>Sales Report</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales_report">Sales by Dates</a></li>
        <li><a href="monthly_sales">Monthly Sales</a></li>
        <li><a href="daily_sales">Daily Sales</a></li>
        <li><a href="product_sales">Product Sales</a></li>
      </ul>
    </li>
    <li>
      <a href="categorie">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Categories</span>
      </a>
    </li>
    <li>
      <a href="media">
        <i class="glyphicon glyphicon-picture"></i>
        <span>Media Files</span>
      </a>
    </li>
    <li class="submenu">
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-user"></i>
        <span>User Management</span>
      </a>
      <ul class="nav submenu">
        <li><a href="group">Manage Groups</a></li>
        <li><a href="users">Manage Users</a></li>
      </ul>
    </li>
    <li class="logo">
      <img src="libs/images/logo.png" alt="ISLAND SEA LOGO" style="height: 100px;">
    </li>
  </ul>
</nav>

<script>
  // Toggle submenu visibility
document.querySelectorAll('.submenu-toggle').forEach(item => {
  item.addEventListener('click', function() {
    this.classList.toggle('active');
  });
});

// Toggle sidebar on small screens (Hamburger menu)
document.querySelector('.menu-toggle').addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('active');
});

</script>
