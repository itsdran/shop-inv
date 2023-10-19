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
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});

	$(document).ready(function () {
		$('#dtDynamicVerticalScrollExample').DataTable({
		"scrollY": "400px",
		"scrollCollapse": true,
		});
		$('.dataTables_length').addClass('bs-select');
	});
</script>
<body style='color: black'>
	<?php include "header_web.html"?>
	<div class="row">
		<div class="column1">
			<ul class="sideLi" id="ulsidebar"><b>
					<li><a class="navs" href="view_item.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Products.png"> PRODUCTS </a> </li>
					<li><a class="navs" href="view_purchase.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Purchase Order.png"> PURCHASE </a></li>
					<li><a class="navs" href="view_stockProvider.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Stock Provider.png"> STOCK PROVIDERS </a></li>
					<li><a class="navs" href="view_sales.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Sales.png"> SALES </a></li>
					<li><a class="navs" href="view_customers.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Customer.png"> CUSTOMER </a></li>
					<li><a class="current" href="view_reports.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Report.png"> REPORTS </a></li>
			</ul></b>
		</div>
			<div class="column2">
				<div class="wrapper">
					<div class="container-fluid" style="border-radius: 35px; background-color: white; margin-top: 40px; padding-bottom: 40px;">
						<div class="row">
							<div class="card card-outline-secondary my-4" style="width: 100% !important;">
								<h2 class="card-header">REPORTS<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></h2>
									<div class="card-body">										
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Products</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#customerReportsTab">Customer</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#saleReportsTab">Sales</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#purchaseReportsTab">Purchase Order</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#vendorReportsTab">Stock Provider</a>
											</li>
										</ul>
										<!-- Tab panes for reports sections -->
										<div class="tab-content">
											<div id="itemReportsTab" class="container-fluid tab-pane active">
												<br>
												<p>Use the grid below to get reports for items</p>
												<div class="table-responsive" id="itemReportsTableDiv"></div>
											</div>
											<div id="customerReportsTab" class="container-fluid tab-pane fade" >
												<br>
												<p>Use the grid below to get reports for customers</p>
												<div class="table-responsive" id="customerReportsTableDiv"></div>
											</div>
											<div id="saleReportsTab" class="container-fluid tab-pane fade">
												<br>
												<!-- <p>Use the grid below to get reports for sales</p> -->
												<form> 
													<div class="form-row">
														<div class="form-group col-md-3">
														<label for="saleReportStartDate">Start Date</label>
														<input type="date" class="form-control" id="saleReportStartDate" value="2020-06-21" name="saleReportStartDate" >
														</div>
														<div class="form-group col-md-3">
														<label for="saleReportEndDate">End Date</label>
														<input type="date" class="form-control" id="saleReportEndDate" value="2025-06-21" name="saleReportEndDate" >
														</div>
													</div>
													<button type="button" id="showSaleReport" class="btn btn-dark">Show Report</button>
													<button type="reset" id="saleFilterClear" class="btn">Clear</button>
												</form>
												<br><br>
												<div class="table-responsive" id="saleReportsTableDiv"></div>
											</div>
											<div id="purchaseReportsTab" class="container-fluid tab-pane fade">
												<br>
												<!-- <p>Use the grid below to get reports for purchases</p> -->
												<form> 
													<div class="form-row">
														<div class="form-group col-md-3">
															<label for="purchaseReportStartDate">Start Date</label>
															<input type="date" class="form-control" id="purchaseReportStartDate" value="2022-06-21" name="purchaseReportStartDate" >
														</div>
															<div class="form-group col-md-3">
																<label for="purchaseReportEndDate">End Date</label>
																<input type="date" class="form-control" id="purchaseReportEndDate" value="2022-06-21" name="purchaseReportEndDate" >
															</div>
													</div>
													<button type="button" id="showPurchaseReport" class="btn btn-dark">Show Report</button>
													<button type="reset" id="purchaseFilterClear" class="btn">Clear</button>
												</form>
													<br><br>
													<div class="table-responsive" id="purchaseReportsTableDiv"></div>
											</div>
											
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>				
		<div id="London" class="tabcontent">
			<!-- Footer -->
<?php include "footer.php"?>
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