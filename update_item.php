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

	$itemName = $status = $itemNumber = $discount = $stock = $unitPrice = $description = $sid = "";
	$itemName_err = $status_err = $itemNumber_err = $discount_err = $stock_err = $unitPrice_err = $description_err = "";

	if(isset($_POST["productID"]) && !empty($_POST["productID"])){

		$id				= $_POST["productID"];
		$itemName 		= $_POST["itemName"];
		$status 	    = $_POST["status"];
		$itemNumber     = $_POST['itemNumber'];
		$discount 		= $_POST["discount"];
		$stock   		= $_POST["stock"];
		$unitPrice 		= $_POST["unitPrice"];
        $description    = $_POST["description"];
        
		// Validate item name
		$input_itemName = trim($_POST["itemName"]);
		if(empty($input_itemName)){
			$itemName_err = "Please enter a name.";
		} elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$itemName_err = "Please enter a valid name.";
		} else{
			$itemName = $input_itemName;
		}
		// Validate item status
		$input_status = trim($_POST["status"]);
		if(empty($input_status)){
			$status_err = "Please enter a status.";
		} elseif(!filter_var($input_status, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$status_err = "Please enter a valid status.";
		} else{
			$status = $input_status;
		}
		// Validate item number
		$input_itemNumber = trim($_POST["itemNumber"]);
		if(empty($input_itemNumber)){
			$status_err = "Please enter a number.";
		} else{
			$itemNumber = $input_itemNumber;
		}
		// Validate item discount
		$input_discount = trim($_POST["discount"]);
		if(empty($input_itemNumber)){
			$discount_err = "Please enter a discount.";
		} else{
			$discount = $input_discount;
		}
		// Validate item stock
		$input_stock = trim($_POST["stock"]);
		if(empty($input_stock)){
			$stock_err = "Please enter a stock.";
		} else{
			$stock = $input_stock;
		}
		// Validate unit price
		$input_unitPrice = trim($_POST["unitPrice"]);
		if(empty($input_unitPrice)){
			$unitPrice_err = "Please enter a price.";
		} else{
			$unitPrice = $input_unitPrice;
		}
		// Validate item description
		$input_description = trim($_POST["description"]);
		if(empty($input_description)){
			$description_err = "Please enter a status.";
		} elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
			$description_err = "Please enter a valid status.";
		} else{
			$description = $input_description;
		}
		if (empty($itemName_err) && empty($status_err) && empty($itemNumber_err) && empty($discount_err) && empty($stock_err) && empty($unitPrice_err) && empty($description_err)) {
			$query = "UPDATE item SET itemName='$itemName', status='$status', itemNumber='$itemNumber', discount='$discount', stock='$stock', unitPrice='$unitPrice', description='$description' WHERE productID='$id'";
			$result = mysqli_query ($link, $query);

			// Attempt to execute the prepared statement
			if ($result) {
				// Records updated successfully. Redirect to landing page
                header("location: view_item.php");
                exit();
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		
	} else {
		if(isset($_GET["productID"]) && !empty(trim($_GET["productID"]))){
			$id =  trim($_GET["productID"]);
			// Prepare a select statement
			$result = mysqli_query ($link,"SELECT * FROM item WHERE productID = '$id'");
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$count = mysqli_num_rows ($result);

			if ($count == 1) {
                $id				= $row["productID"];
                $itemName 		= $row["itemName"];
                $stat 	        = $row["status"];
                $itemNumber     = $row['itemNumber'];
                $discount 		= $row["discount"];
                $stock   		= $row["stock"];
                $unitPrice 		= $row["unitPrice"];
                $description    = $row["description"];
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
					<li><a class="current" href="view_item.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Products.png"> PRODUCTS </a> </li>
					<li><a class="navs" href="view_purchase.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Purchase Order.png"> PURCHASE </a></li>
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
						<div class="card-header" style="border-radius: 35px 35px 0 0"  >Product Details</div>
						<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Details</a>
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
												<input type="text" required name="itemName"
													class="form-control <?php echo (!empty($itemName_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $itemName; ?>">
												<span class="invalid-feedback"><?php echo $itemName_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Status</label>
												<select name="status" class="form-control chosenSelect">
													<?php include('statusList.html'); ?>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label for="vendorDetailsStatus">Item Number</label>
												<input type="text" name="itemNumber" class="form-control"
													autocomplete="off" value="<?php echo $itemNumber; ?>" />
											</div>
										</div>
										<div class="form-row">
                                            <div class="form-group col-md-3">
												<label for="vendorDetailsStatus">Discount %</label>
												<input type="text" name="discount" class="form-control"
													autocomplete="off" value="<?php echo $discount; ?>" />
											</div>
                                            <div class="form-group col-md-3">
												<label for="vendorDetailsStatus">Stock</label>
												<input type="text" name="stock" class="form-control"
													autocomplete="off" value="<?php echo $stock; ?>" />
											</div>
                                            <div class="form-group col-md-3">
												<label for="vendorDetailsStatus">Unit Price</label>
												<input type="text" name="unitPrice" class="form-control"
													autocomplete="off" value="<?php echo $unitPrice; ?>" />
											</div>
                                            <div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Product ID</label>
												<input type="text" readonly name="productID" class="form-control"
													autocomplete="off" value="<?php echo $id; ?>" />
											</div>
										</div>
                                        <div class="form-row">
											<div class="form-group col-md-6" style="display:inline-block">
											    <label for="itemDetailsDescription">Description</label> 
											    <textarea  rows="7" name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" id="itemDetailsDescription"><?php echo $description;?></textarea>
                            				<span class="invalid-feedback"><?php echo $description_err;?></span>
											</div>
										</div>
<<<<<<< Updated upstream
=======
										<br><br><br><br>
										<input type="submit" style="background-color: #ECAC3D; border-color: #ECAC3D;" href="create_item.php" class="btn btn-success"value="Update Item">
										<a href="view_item.php">
										<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
										</a> 
										<button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
									</form>
>>>>>>> Stashed changes
								</div>
							</div>

							<input type="submit" class="btn btn-primary" value="Update Product">
							<a href="view_item.php">
								<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
							</a>
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
	<br><br><br><br><br>
	<br><br><br><br><br>
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