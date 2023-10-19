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

// Define variables and initialize with empty values
    $itemName = $customerName = $date = $discount = $quantity = $unitPrice = $sid = "";
    $itemName_err = $customerName_err = $date_err = $discount_err = $quantity_err = $unitPrice_err = "";
    //$id = $_GET['saleID'];
if(isset($_POST["saleID"]) && !empty($_POST["saleID"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM sales WHERE saleID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["saleID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: view_sales.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
}else{
    // Check existence of id parameter before processing further
    if(isset($_GET["saleID"]) && !empty(trim($_GET["saleID"]))){
        // Get URL parameter
        $id =  trim($_GET["saleID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM sales WHERE saleID = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
					$itemName 		= $row["itemName"];
                    $customerName 	= $row["customerName"];
                    $date 			= $row['saleDate'];
                    $discount 		= $row["discount"];
                    $quantity 		= $row["quantity"];
                    $unitPrice 		= $row["unitPrice"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<script type="text/javascript">
	    $(window).on('load', function() {
	        $('#myModal').modal('show');
	    });
</script>
<body>
    <div class="modal" id="myModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title">Delete Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<div class="modal-body">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="alert alert-danger">
					<input type="hidden" name="saleID" value="<?php echo trim($_GET["saleID"])?>"/>
					<p>Are you sure you want to delete this record?</p>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Yes" class="btn btn-danger">
					<a href="view_sales.php" class="btn btn-secondary" data-dismiss="modal">No</a>
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
						<div class="card-header" style="border-radius: 35px 35px 0 0">Sales Details</div>
						<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Sale</a>
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