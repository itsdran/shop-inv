<?php
	session_start();
	// Redirect the user to login page if he is not logged in.
	if(!isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}
	require_once "config.php";
	require_once('header.html');
?>
<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<a style="text-decoration: none; color:white" href="index.html"><img src="assets/img/logo-w.png" style="width:60px">&nbsp Thrifted Goods PH | Inventory </a>
		<a class="d-md-inline-block" style="color:white; margin-left: 1350px" name=sid>Welcome <?php echo $_SESSION['fullName']; ?> &nbsp | <b>
			</b></a>
		<a class="d-md-inline-block" style="color:white" href="model/login/logout.php">&nbspLog Out</a>
        
	</nav>
	<div class="row">
		<div class="column1">
			<ul class="sideLi" id="ulsidebar"><b>
					<li><a class="navs" href="view_item.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Products.png"> PRODUCTS </a> </li>
					<li><a class="navs" href="view_purchase.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Purchase Order.png"> PURCHASE </a></li>
					<li><a class="navs" href="view_stockProvider.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Stock Provider.png"> STOCK PROVIDERS </a></li>
					<li><a class="current" href="view_sales.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Sales.png"> SALES </a></li>
					<li><a class="navs" href="view_customers.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Customer.png"> CUSTOMER </a></li>
					<li><a class="navs" href="view_reports.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Report.png"> REPORTS </a></li>
			</ul></b>
		</div>
			<div class="column2">
				<div class="wrapper">
					<div class="container-fluid" style=" border-radius: 35px; background-color: white; margin-top: 40px; padding-bottom: 40px; ">
						<div class="row">
							<div class="col-md-12">
								<div class="mt-2 mb-3 clearfix" >
									<table style="width: 94%;  margin: auto;"><tr><td valign="bottom">
									<h2 class="pull-left">Sales Details</h2>
									</td>
									<td valign="bottom">
									<a style="background-color: #ECAC3D; border-color: #ECAC3D;" href="create_sales.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Sale</a>
									</td></tr></table>
								</div><br>
								<?php
								// Include config file
								require_once "config.php";
								
								// Attempt select query execution
								$sql = "SELECT * FROM sales";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){
										echo '<table id="dtDynamicVerticalScrollExample" class="table table-hover table-sm table-striped">';
											echo "<thead>";
												echo "<tr>";
													echo "<th>Sale ID</th>";
													echo "<th>Item Number</th>";
													echo "<th>Item Name</th>";
													echo "<th>Customer Name</th>";
													echo "<th>Date</th>";
													echo "<th>Quantity</th>";
													echo "<th>Discount</th>";
													echo "<th>Unit Price</th>";
													echo "<th>Action</th>";
												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											while($row = mysqli_fetch_array($result)){
												echo "<tr>";
													echo "<td style='color:black;'>" . $row['saleID'] . "</td>";
													echo "<td style='color:black;'>" . $row['itemNumber'] . "</td>";
													echo "<td style='color:black;'>" . $row['itemName'] . "</td>";
													echo "<td style='color:black;'>" . $row['customerName'] . "</td>";
													echo "<td style='color:black;'>" . $row['saleDate'] . "</td>";
													echo "<td style='color:black;'>" . $row['quantity'] . "</td>";
													echo "<td style='color:black;'>" . $row['discount'] . "</td>";
													echo "<td style='color:black;'>" . $row['unitPrice'] . "</td>";
													echo "<td style='color:black; text-align: center;'>";
														echo '<a href="update_sales.php?saleID='. $row['saleID'] .'" class="mr-4" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
														echo '<a href="delete_sales.php?saleID='. $row['saleID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
													echo "</td>";
												echo "</tr>";
											}
											echo "</tbody>";                            
										echo "</table>";
										// Free result set
										mysqli_free_result($result);
									} else{
										echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
									}
								} else{
									echo "Oops! Something went wrong. Please try again later.";
								}
				
								// Close connection
								mysqli_close($link);
								?> <br><br><br><br>
							</div>
						</div>        
					</div>
				</div>  	
			</div>
		</div>
			<!-- Footer -->
		<footer class="footer fixed-bottom">
			<div class="container">
			<p class="text-center text-white">Copyright &copy; Inventory System <?php echo date('Y'); ?></p>
			</div>
		</footer>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		

		<!-- Bootstrap core JavaScript -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		
		<!-- Datatables script -->
		<script type="text/javascript" charset="utf8" src="vendor/DataTables/datatables.js"></script>
		<script type="text/javascript" charset="utf8" src="vendor/DataTables/sumsum.js"></script>
		
		<!-- Chosen files for select boxes -->
		<script src="vendor/chosen/chosen.jquery.min.js"></script>
		<link rel="stylesheet" href="vendor/chosen/chosen.css" />
		
		<!-- Datepicker JS -->
		<script src="vendor/datepicker164/js/bootstrap-datepicker.min.js"></script>
		
		<!-- Bootbox JS -->
		<script src="vendor/bootbox/bootbox.min.js"></script>
		
		<!-- Custom scripts -->
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/login.js"></script>
</body>
</html>
