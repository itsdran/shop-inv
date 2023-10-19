<?php
session_start();
// Redirect the user to login page if he is not logged in.
if(!isset($_SESSION['loggedIn'])){
	header('Location: login.php');
	exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('header.html');
    
?>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<a style="text-decoration: none; color:white" href="index.html"><img src="assets/img/logo-w.png" style="width:60px">&nbsp Thrifted Goods PH | Inventory </a>
		<a class="d-md-inline-block" style="color:white; margin-left: 830px" name=sid>Welcome <?php echo $_SESSION['fullName']; ?> &nbsp | <b>
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
			<div class="tab-content roundContainer" id="v-pills-tabContent">
				<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel"
					aria-labelledby="v-pills-item-tab">
					<div class="card card-outline-secondary" style="border-radius: 35px 35px 0 0 ">
					<div class="card-header" style="border-radius: 35px 35px 0 0 ">Sale Details</div>
						<div class="card-body">
							<div id="saleDetailsMessage"></div>
							<form>
							<div class="form-row">
								<div class="form-group col-md-3">
								<label for="saleDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
								<input type="text" class="form-control" id="saleDetailsItemNumber" name="saleDetailsItemNumber" autocomplete="off">
								<div id="saleDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
								</div>
								<div class="form-group col-md-3">
									<label for="saleDetailsCustomerID">Customer ID<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control" id="saleDetailsCustomerID" name="saleDetailsCustomerID" autocomplete="off">
									<div id="saleDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
								</div>
								<div class="form-group col-md-4">
								<label for="saleDetailsCustomerName">Customer Name</label>
								<input type="text" class="form-control" id="saleDetailsCustomerName" name="saleDetailsCustomerName" readonly>
								</div>
								<div class="form-group col-md-2">
								<label for="saleDetailsSaleID">Sale ID</label>
								<input type="text" readonly class="form-control invTooltip" id="saleDetailsSaleID" name="saleDetailsSaleID" title="This will be auto-generated when you add a new record" autocomplete="off">
								<div id="saleDetailsSaleIDSuggestionsDiv" class="customListDivWidth"></div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-5">
									<label for="saleDetailsItemName">Item Name</label>
									<!--<select id="saleDetailsItemNames" name="saleDetailsItemNames" class="form-control chosenSelect"> -->
										<?php 
											//require('model/item/getItemDetails.php');
										?>
									<!-- </select> -->
									<input type="text" class="form-control invTooltip" id="saleDetailsItemName" name="saleDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
								</div>
								<div class="form-group col-md-3">
									<label for="saleDetailsSaleDate">Sale Date<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control datepicker" id="saleDetailsSaleDate" value="2018-05-24" name="saleDetailsSaleDate" readonly>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
										<label for="saleDetailsTotalStock">Total Stock</label>
										<input type="text" class="form-control" name="saleDetailsTotalStock" id="saleDetailsTotalStock" readonly>
										</div>
								<div class="form-group col-md-2">
								<label for="saleDetailsDiscount">Discount %</label>
								<input type="text" class="form-control" id="saleDetailsDiscount" name="saleDetailsDiscount" value="0">
								</div>
								<div class="form-group col-md-2">
								<label for="saleDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
								<input type="number" class="form-control" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0">
								</div>
								<div class="form-group col-md-2">
								<label for="saleDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
								<input type="text" class="form-control" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0">
								</div>
								<div class="form-group col-md-3">
								<label for="saleDetailsTotal">Total</label>
								<input type="text" class="form-control" id="saleDetailsTotal" name="saleDetailsTotal">
								</div>
							</div>
<<<<<<< Updated upstream
							<button type="button" id="addSaleButton" class="btn btn-success">Add Sale</button>
=======
							<br><br><br><br><br>
							<button type="button" id="addSaleButton" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success">Add Sale</button>
>>>>>>> Stashed changes
							<a href="view_sales.php">
								<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
							</a> 
							<button type="reset" class="btn btn-secondary">Clear</button>
							</form>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<!-- Footer -->
	<br><br><br><br><br><br><br><br><br>
	<?php include "footer.php"?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
	</script>


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