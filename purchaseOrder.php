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
<!-- Page Content -->
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-2">
				<h1 class="my-4"></h1>
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
			</div>
			<div class="col-lg-10" align="center">
				<div class="tab-pane fade" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
					<div class="card card-outline-secondary my-4">
					  <div class="card-header">Purchase Order Details</div>
						<div class="card-body">
							<div id="purchaseDetailsMessage"></div>
							<form>
							  <div class="form-row">
								<div class="form-group col-md-3">
								  <label for="purchaseDetailsItemNumber">Product Number<span class="requiredIcon">*</span></label>
								  <input type="text" class="form-control" id="purchaseDetailsItemNumber" name="purchaseDetailsItemNumber" autocomplete="off">
								  <div id="purchaseDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
								</div>
								<div class="form-group col-md-3">
								  <label for="purchaseDetailsPurchaseDate">Purchase Order Date<span class="requiredIcon">*</span></label>
								  <input type="text" class="form-control datepicker" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" readonly value="2018-05-24">
								</div>
								<div class="form-group col-md-2">
								  <label for="purchaseDetailsPurchaseID">Purchase Order ID</label>
								  <input type="text" class="form-control invTooltip" id="purchaseDetailsPurchaseID" name="purchaseDetailsPurchaseID" title="This will be auto-generated when you add a new record" autocomplete="off">
								  <div id="purchaseDetailsPurchaseIDSuggestionsDiv" class="customListDivWidth"></div>
								</div>
							  </div>
							  <div class="form-row"> 
								  <div class="form-group col-md-4">
									<label for="purchaseDetailsItemName">Product Name<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control invTooltip" id="purchaseDetailsItemName" name="purchaseDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
								  </div>
								  <div class="form-group col-md-2">
									  <label for="purchaseDetailsCurrentStock">Current Stock</label>
									  <input type="text" class="form-control" id="purchaseDetailsCurrentStock" name="purchaseDetailsCurrentStock" readonly>
								  </div>
								  <div class="form-group col-md-4">
									<label for="purchaseDetailsVendorName">Stock Provider Name<span class="requiredIcon">*</span></label>
									<select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
										<?php 
											require('model/stockProvider/getVendorNames.php');
										?>
									</select>
								  </div>
							  </div>
							  <div class="form-row">
								<div class="form-group col-md-2">
								  <label for="purchaseDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
								  <input type="number" class="form-control" id="purchaseDetailsQuantity" name="purchaseDetailsQuantity" value="0">
								</div>
								<div class="form-group col-md-2">
								  <label for="purchaseDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
								  <input type="text" class="form-control" id="purchaseDetailsUnitPrice" name="purchaseDetailsUnitPrice" value="0">
								  
								</div>
								<div class="form-group col-md-2">
								  <label for="purchaseDetailsTotal">Total Cost</label>
								  <input type="text" class="form-control" id="purchaseDetailsTotal" name="purchaseDetailsTotal" readonly>
								</div>
							  </div>
							  <button type="button" id="addPurchase" class="btn btn-success">Add Purchase</button>
							  <button type="button" id="updatePurchaseDetailsButton" class="btn btn-primary">Update</button>
							  <button type="reset" class="btn">Clear</button>
							</form>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<html>