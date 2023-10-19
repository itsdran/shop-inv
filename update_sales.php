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

	$itemName = $customerName = $date = $discount = $quantity = $unitPrice = $sid = "";
	$itemName_err = $customerName_err = $date_err = $discount_err = $quantity_err = $unitPrice_err = "";

	if(isset($_POST["saleID"]) && !empty($_POST["saleID"])){
		$id				= $_POST ["saleID"];
		$itemName 		= $_POST["itemName"];
		$customerName 	= $_POST["customerName"];
		$date 			= $_POST['saleDate'];
		$discount 		= $_POST["discount"];
		$quantity 		= $_POST["quantity"];
		$unitPrice 		= $_POST ["unitPrice"];

		$input_itemName = trim($_POST["itemName"]);
		if(empty($input_itemName)){
			$itemName_err = "Please enter a name.";
		} elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$itemName_err = "Please enter a valid name.";
		} else{
			$itemName = $input_itemName;
		}

		$input_customerName = trim($_POST["customerName"]);
		if(empty($input_customerName)){
			$customerName_err = "Please enter a name.";
		} elseif(!filter_var($input_customerName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$customerName_err = "Please enter a valid name.";
		} else{
			$customerName = $input_customerName;
		}

		$input_date = trim($_POST["saleDate"]);
		if(empty($input_date)){
			$date_err = "Please enter a date.";
		} elseif(!filter_var($input_date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$date_err = "Please enter a valid date.";
		} else{
			$date = $input_date;
		}

		$input_discount = $_POST["discount"];
		if(empty($input_discount)){
			$discount_err = "Please enter a discount.";
		} else{
			$discount = $input_discount;
		}

		$input_quantity = $_POST["quantity"];
		if(empty($input_quantity)){
			$quantity_err = "Please enter a discount.";
		} else{
			$quantity = $input_quantity;
		}

		$input_unitPrice = $_POST["unitPrice"];
		if(empty($input_unitPrice)){
			$unitPrice_err = "Please enter a discount.";
		} else{
			$unitPrice = $input_unitPrice;
		}

		if (empty($itemName_err) && empty($customerName_err) && empty($saleDate) && empty($discount_err) && empty($quantity_err) && empty($unitPrice_err)) {

			$query = "UPDATE sales SET itemName='$itemName', customerName='$customerName', saleDate='$date', discount='$discount', quantity='$quantity', unitPrice='$unitPrice' WHERE saleID='$id'";
			$result = mysqli_query ($link, $query);

			// Attempt to execute the prepared statement
			if ($result) {
				// Records updated successfully. Redirect to landing page
                header("location: view_sales.php");
                exit();
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		
	} else {
		if(isset($_GET["saleID"]) && !empty(trim($_GET["saleID"]))){
			$id =  trim($_GET["saleID"]);
        
			// Prepare a select statement
			$result = mysqli_query ($link,"SELECT * FROM sales WHERE saleID = '$id'");
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$count = mysqli_num_rows ($result);

			if ($count == 1) {
				$itemName 		= $row["itemName"];
				$customerName 	= $row["customerName"];
				$date 			= $row['saleDate'];
				$discount 		= $row["discount"];
				$quantity 		= $row["quantity"];
				$unitPrice 		= $row["unitPrice"];
			} else {
				header("location: error.php");
				exit();
			}
		}
	}
?>
<body>
<?php include "header_web.html"?>
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
					<div class="card card-outline-secondary" style="border-radius: 35px 35px 0 0">
					<h2 class="card-header" style="background-color: transparent;">Sales Details</h2>
				<div class="card-body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Sales</a>
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
<<<<<<< Updated upstream
                                            <div class="form-group col-md-6">
												<label for="vendorDetailsVendorFullName">Customer Name<span
														class="requiredIcon">*</span></label>
												<input type="text" required name="customerName" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $customerName; ?>">
												<span class="invalid-feedback"><?php echo $customerName_err;?>
											</div>
										</div>
										<div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label>Sale Date*</label>
                                                    <input type="date" required name="saleDate"
                                                        class="form-control <?php echo (!empty($vendorName_err)) ? 'is-invalid' : ''; ?>"
                                                        autocomplete="off" value="<?php echo $date; ?>">
                                                        <span class="invalid-feedback"><?php echo $date_err;?>
                                                </div>
											<div class="form-group col-md-4">
												<label for="vendorDetailsVendorMobile">Discount<span
														class="requiredIcon">*</span></label>
												<input type="text" required name="discount"
													class="form-control <?php echo (!empty($discount_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $discount; ?>">
												<span class="invalid-feedback"><?php echo $discount_err;?>
											</div>
                                            <div class="form-group col-md-2">
                                                <label for="vendorDetailsStatus">Sales ID</label>
                                                <input type="text" readonly name="saleID" class="form-control"
                                                    autocomplete="off" value="<?php echo $id; ?>" />
                                            </div>
										</div>
										<div class="form-row">
                                            <div class="form-group col-md-4">
												<label for="vendorDetailsVendorMobile">Quantity<span
														class="requiredIcon">*</span></label>
												<input type="text" required name="quantity"
													class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $quantity; ?>">
												<span class="invalid-feedback"><?php echo $quantity_err;?>
											</div>
                                            <div class="form-group col-md-4">
												<label for="vendorDetailsVendorMobile">Unit Price<span
														class="requiredIcon">*</span></label>
												<input type="text" required name="unitPrice"
													class="form-control <?php echo (!empty($unitPrice_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $unitPrice; ?>">
												<span class="invalid-feedback"><?php echo $unitPrice_err;?>
											</div>
										</div>
								</div>
							</div>
							<input type="submit" class="btn btn-primary" value="Update Sale" name="updateSale">
							<a href="view_sales.php">
								<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
							</a>
							<button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
							</form>
=======
									<div class="form-group col-md-2">
									<label for="saleDetailsDiscount">Discount %</label>
									<input type="text" class="form-control" id="saleDetailsDiscount" name="saleDetailsDiscount" value="0">
									</div>
									<div class="form-group col-md-2">
									<label for="saleDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
									<input type="number" value="<?php echo $quantity; ?>" class="form-control" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0">
									</div>
									<div class="form-group col-md-2">
									<label for="saleDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
									<input type="text" value="<?php echo $unitPrice; ?>" class="form-control" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0">
									</div>
									<div class="form-group col-md-3">
									<label for="saleDetailsTotal">Total</label>
									<input type="text" class="form-control" id="saleDetailsTotal" name="saleDetailsTotal">
									</div>
								</div><br><br><br><br><br><br>
								<button type="button" id="updateSaleDetailsButton" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success">Update Sale</button>
								<a href="view_sales.php">
									<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
								</a> 
								<button type="reset" class="btn btn-secondary">Clear</button>
								</form>
							</div> 
>>>>>>> Stashed changes
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<!-- Footer --><br><br><br><br>
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