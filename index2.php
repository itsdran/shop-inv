<?php
	session_start();
	// Redirect the user to login page if user is not logged in.
	if(!isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}
	
	require_once('constants.php');
	require_once('db.php');
	require_once('header.html');
?>
  <body>
<?php
	require 'navigation.php';
?>
    <!-- Page Content -->
<?php
	require 'footer.php';
?>
<!-- Sidebar -->
    <div class="sidebar-fixed position-fixed">

      <a class="logo-wrapper waves-effect">
      
        <img src="pic/ocs.jpg" width="150px" height="200px;" class="img-fluid" alt="">
      </a>

      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item active waves-effect">
          <i class="fas fa-chart-pie mr-3"></i>Home
        </a>
         <a href="product.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-user mr-3"></i>Products</a>
            <a href="purchaseOrder.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-users"></i> Purchase Order</a>
        <a href="stockProvider.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-user mr-3"></i>Stock Provider</a>
           <a href="sales.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-users"></i>  Sales</a>
        <a href="customer.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-file-medical"></i> Customer</a>
        <a href="archive.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-folder-open"></i> Archive</a>
            <a href="reports.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-chalkboard-teacher"></i> Reports</a>
      </div>

    </div>
    <!-- Sidebar -->

  </body>
</html>
