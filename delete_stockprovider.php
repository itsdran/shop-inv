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
$vendorName = $companyName = $address = $mobile = $address = $status = $sid = "";
$name_err = $address_err = $salary_err = "";
 
if(isset($_POST["sProviderID"]) && !empty($_POST["sProviderID"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM stockprovider WHERE sProviderID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["sProviderID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: view_stockProvider.php");
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
    if(isset($_GET["sProviderID"]) && !empty(trim($_GET["sProviderID"]))){
        // Get URL parameter
        $id =  trim($_GET["sProviderID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM stockprovider WHERE sProviderID = ?";
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
					$companyName = $row["companyName"];
					$vendorName = $row["vendorName"];
					$email = $row["email"];
					$mobile = $row["mobile"];
					$status = $row["status"];
					$address = $row["address"];
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
			<h5 class="modal-title">Delete Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<div class="modal-body">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="alert alert-danger">
					<input type="hidden" name="sProviderID" value="<?php echo trim($_GET["sProviderID"]); ?>"/>
					<p>Are you sure you want to delete this record?</p>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Yes" class="btn btn-danger">
					<a href="view_item.php" class="btn btn-secondary" data-dismiss="modal">No</a>
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
					<li><a class="current" href="view_stockProvider.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Stock Provider.png"> STOCK PROVIDERS </a></li>
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
								<h2 class="card-header" style="background-color: transparent;">Stock Provider Details</h2>
						<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Stock Provider</a>
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
												<label for="vendorDetailsVendorFullName">Company Name<span
														class="requiredIcon">*</span></label>
												<input type="text" readonly required name="companyName" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $companyName; ?>">
												<span class="invalid-feedback"><?php echo $name_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Status</label>
												<input type="text" readonly required name="status"
													class="form-control" autocomplete="off" value="<?php echo $status; ?>">
											</div>
											<div class="form-group col-md-3">
												<label>Handler Fullname*</label>
												<input type="text" readonly required name="vendorName"
													class="form-control <?php echo (!empty($vendorName_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $vendorName; ?>">
												<span class="invalid-feedback"><?php echo $vendorName_err;?>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-3">
												<label for="vendorDetailsVendorMobile">Contact Number<span
														class="requiredIcon">*</span></label>
												<input type="tel" readonly required name="mobile"
													class="form-control <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $mobile; ?>">
												<span class="invalid-feedback"><?php echo $mobile_err;?>
											</div>
											<div class="form-group col-md-4">
												<label for="vendorDetailsVendorEmail">Email*</label>
												<input type="text" readonly required name="email"
													class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $email; ?>">
												<span class="invalid-feedback"><?php echo $email_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Stock Provider ID</label>
												<input type="text" readonly name="sProviderID" class="form-control"
													autocomplete="off" value="<?php echo $id; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="vendorDetailsVendorAddress">Complete Address<span
													class="requiredIcon">*</span></label>
											<input type="text" readonly required name="address"
												class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $address; ?>">
											<span class="invalid-feedback"><?php echo $address_err;?>
										</div>
										<a href="view_stockProvider.php">
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