<?php
session_start();
// Redirect the user to login page if he is not logged in.
if(!isset($_SESSION['loggedIn'])){
	header('Location: login.php');
	exit();
}
// Include config file
require_once "config.php";
require_once('header.html');

	$itemName = $itemNumber = $vendorName = $vendorID = $purchaseDate = $quantity = $unitPrice = $sid = "";
	$itemName_err = $itemNumber_err = $vendorName_err = $vendorID_err = $purchaseDate_err = $quantity_err = $unitPrice_err = "";

	if (isset ($_POST['purchaseID'])) {

		$id 			= $_POST['purchaseID'];
		$itemName 		= $_POST['itemName'];
		$itemNumber 	= $_POST['itemNumber'];
		$vendorName 	= $_POST['vendorName'];
		$vendorID 		= $_POST['vendorID'];
		$purchaseDate 	= $_POST['purchaseDate'];
		$quantity 		= $_POST['quantity'];
		$unitPrice 		= $_POST['unitPrice'];

		$query = "	DELETE FROM purchase WHERE purchaseID = '$id'";
		$result = mysqli_query ($link, $query);

		if ($result) {
			//Records deleted successfully. Redirect to landing page
			header("location: view_purchase.php");
			exit();
		} else {
			echo "Oops! Something went wrong. Please try again later.";
		}
	}  else {
		if(isset($_GET["purchaseID"]) && !empty(trim($_GET["purchaseID"]))){
			$id =  trim($_GET["purchaseID"]);

			$query = "SELECT * FROM purchase WHERE purchaseID = '$id'";
			$result = mysqli_query ($link, $query);
			$row = mysqli_fetch_array ($result);
			$count = mysqli_num_rows ($result);

			if ($count == 1) {
				$itemName 		= $row['itemName'];
				$itemNumber 	= $row['itemNumber'];
				$vendorName 	= $row['vendorName'];
				$vendorID 		= $row['vendorID'];
				$purchaseDate 	= $row['purchaseDate'];
				$quantity 		= $row['quantity'];
				$unitPrice 		= $row['unitPrice'];	
			}
		}
	}

?>
<script type="text/javascript">
	$(window).on('load', function() {
		$('#myModal').modal('show');
	});
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	$(document).ready(function() {
		$('#dtDynamicVerticalScrollExample').DataTable({
			"scrollY": "400px",
			"scrollCollapse": true,
		});
		$('.dataTables_length').addClass('bs-select');
	});
</script>
<body>
		<div class="modal" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title">Delete Purchase</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="alert alert-danger">
						<input type="hidden" name="purchaseID" value="<?php echo trim($_GET["purchaseID"]); ?>"/>
						<p>Are you sure you want to delete this purchase record?</p>
					</div>
					<div class="modal-footer">
						<input type="submit" value="Yes" class="btn btn-danger">
						<a href="view_item.php" class="btn btn-secondary">No</a>
					</div>
				</form>
				</div>
			</div>
			</div>
		</div>
<?php include "header_web.html"?>
	<div class="row">
		<div class="column1">
			<ul class="sideLi" id="ulsidebar"><b>
					<li><a class="navs" href="view_item.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Products.png"> PRODUCTS </a> </li>
					<li><a class="current" href="view_purchase.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Purchase Order.png"> PURCHASE </a></li>
					<li><a class="navs" href="view_stockProvider.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Stock Provider.png"> STOCK PROVIDERS </a></li>
					<li><a class="navs" href="view_sales.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Sales.png"> SALES </a></li>
					<li><a class="navs" href="view_customers.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Customer.png"> CUSTOMER </a></li>
					<li><a class="navs" href="view_reports.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Report.png"> REPORTS </a></li>
			</ul></b>
		</div>
		<div class="column2">
			<div class="tab-content roundContainer" id="v-pills-tabContent">
				<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" 
				aria-labelledby="v-pills-item-tab">
					<div class="card card-outline-secondary" style="border-radius: 35px 35px 0 0">
					<h2 class="card-header" style="background-color: transparent;">Purchase Details</h2>
							<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Item</a>
								</li>
							</ul>
							
							<!-- Tab panes for item details and image sections -->
							<div class="tab-content">
								<div id="itemDetailsTab" class="container-fluid tab-pane active">
									<br>
									<!-- Div to show the ajax message from validations/db submission -->
									<div id="itemDetailsMessage"></div>
									<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
									method="post">
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="vendorDetailsVendorFullName">Item Name<span
													class="requiredIcon">*</span></label>
											<input type="text" required name="itemName" class="form-control <?php echo (!empty($itemName_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $itemName;?>">
											<span class="invalid-feedback"><?php echo $itemName_err;?>
										</div>
										<div class="form-group col-md-3">
											<label for="vendorDetailsStatus">Item Number</label>
											<input type="text" readonly name="itemNumber" class="form-control"
												autocomplete="off" value="<?php echo $itemNumber; ?>" />
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="vendorDetailsVendorFullName">Vendor Name<span
													class="requiredIcon">*</span></label>
											<input type="text" required name="vendorName" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $vendorName; ?>">
											<span class="invalid-feedback"><?php echo $vendorName_err;?>
										</div>
										<div class="form-group col-md-3">
											<label for="vendorDetailsStatus">Vendor ID</label>
											<input type="text" readonly name="vendorID" class="form-control"
												autocomplete="off" value="<?php echo $vendorID; ?>" />
										</div>
										<div class="form-group col-md-2">
											<label for="vendorDetailsStatus">Purchase ID</label>
											<input type="text" readonly name="purchaseID" class="form-control"
												autocomplete="off" value="<?php echo $id; ?>" />
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="vendorDetailsVendorMobile">Unit Price<span
													class="requiredIcon">*</span></label>
											<input type="text" required name="unitPrice"
												class="form-control <?php echo (!empty($unitPrice_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $unitPrice; ?>">
											<span class="invalid-feedback"><?php echo $unitPrice_err;?>
										</div>
										<div class="form-group col-md-3">
											<label for="vendorDetailsVendorMobile">Quantity<span
													class="requiredIcon">*</span></label>
											<input type="text" required name="quantity"
												class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $quantity; ?>">
											<span class="invalid-feedback"><?php echo $quantity_err;?>
										</div>
										<div class="form-group col-md-3">
											<label>Purchase Date*</label>
											<input type="date" required name="purchaseDate"
												class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $purchaseDate; ?>">
												<span class="invalid-feedback"><?php echo $date_err;?>
										</div>
									</div>
									
							</div>
						</div>
						<input type="submit" class="btn btn-primary" value="Update Purchase" name="updateSale">
						<a href="view_purchase.php">
							<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
						</a>
						<button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
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
