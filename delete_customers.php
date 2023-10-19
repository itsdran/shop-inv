<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $mobile = $address = $sid = "";
$name_err = $address_err = $salary_err = "";
 
if(isset($_POST["customerID"]) && !empty($_POST["customerID"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM customer WHERE customerID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["customerID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: view_customers.php");
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
    if(isset($_GET["customerID"]) && !empty(trim($_GET["customerID"]))){
        // Get URL parameter
        $id =  trim($_GET["customerID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM customer WHERE customerID = ?";
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
                    $name = $row["fullName"];
                    $mobile = $row["mobile"];
                    $email = $row["email"];
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
<!DOCTYPE html>
<html>

<head>
	<title> Inventory System </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Datatables CSS -->
	<link rel="stylesheet" type="text/css" href="vendor/DataTables/datatables.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
	body {
		background-color: #dbe6fd;
	}

	.footer {
		position: static;
		background-color: maroon;
		margin-top: 90px;
		margin-bottom: 0px;
		width: 100%;
		height: 60px;
		/* Set the fixed height of the footer here */
		line-height: 60px;
		/* Vertically center the text there */
	}

	.nav2 {
		background-color: white;
		height: 85px;
		width: 100%;
		position: static;
		float: right;
		display: inline-block;
	}

	#bodyContainer {
		width: 70%;
		background-repeat: no-repeat;
		display: inline;
		background-color: blue;
		float: right;
	}

	#ulsidebar {
		top: 40px;
		bottom: 50px;
		background-color: #293b5f;
		width: 100%;
		height: 600px;
		position: relative;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		font-size: 18px;
		list-style-type: none;
		color: white;
		padding: 0;
		overflow: auto;
	}

	#content {}

	.sideLi a {
		height: 60px;
		display: block;
		color: white;
		padding: 20px;
		text-decoration: none;
	}

	.sideLi a.active {
		background-color: #47597E;
		color: white;
	}

	.sideLi a:hover:not(.active) {
		background-color: #DBE6FD;
		color: #293B5F;
	}

	#mainPanel {
		top: 40px;
		background-color: white;
		width: 97%;
		right: 0px;
		bottom: 0px;
		float: right;
		height: 600px;
		position: relative;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}

	div {}

	.row {
		margin: auto;
		width: 100%;
	}

	.column1 {
		width: 18%;
		margin-left: 30px;

	}

	.column2 {
		margin-top: 40px;
		width: 75%;
		margin-left: 30px;
	}

	.column3 {
		width: 40%;

	}

	.column4 {
		width: 58%;
		margin-left: 2%;

	}

	h2 {
		margin-top: 30px;
		color: #293b5f;
		font-family: "Times New Roman", Times, serif;
	}

	td {
		height: 30px;
		color: white;
		text-align: left;
		font-size: 13px;
	}

	.c1 {
		width: 25%;
	}

	.c2 .c4 {
		width: 5%;
	}

	.c3 {
		width: 35%;
	}

	.c5 .c6 .c7 {
		width: 10%;
	}

	.viewInfoDiv {
		margin: auto;
		border: 1px solid #47597E;
		width: 90%;
		height: 490px;
	}

	.viewInfoBg {
		width: 100%;
		height: 450px;
		background-color: #B2AB8C;
		float: right;
	}

	.font {
		font-family: Serif;
		font-size: 18px;
	}
</style>
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
					<input type="hidden" name="customerID" value="<?php echo trim($_GET["customerID"]); ?>"/>
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
<<<<<<< Updated upstream
	<nav
		class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<img src="header.png" style="margin-left: 0px; width">
		<a class="py-2 d-none d-md-inline-block font" name=sid>Welcome Admin<b><?php echo $sid; ?> </b></a>
	</nav>
=======
	<?php include "header_web.html"?>
>>>>>>> Stashed changes
	<div class="row">
		<div class="column1">
			<ul id="ulsidebar"><b>
					<li class="sideLi"><a href="view_item.php">PRODUCTS</a></li>
					<li class="sideLi"><a href="view_purchase.php">PURCHASE</a></li>
					<li class="sideLi"><a href="view_stockProvider.php">STOCK PROVIDERS</a></li>
					<li class="sideLi"><a href="view_sales.php">SALES</a></li>
					<li class="sideLi"><a class="active" href="view_customers.php">CUSTOMER</a></li>
					<li class="sideLi"><a href="view_reports.php">REPORTS</a></li>
				</b>
		</div>
		<div class="column2">
			<div class="tab-content" id="v-pills-tabContent">
				<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel"
					aria-labelledby="v-pills-item-tab">
					<div class="card card-outline-secondary">
						<div class="card-header">Customer Details</div>
						<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Customer</a>
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
												<label for="vendorDetailsVendorFullName">Full Name<span
														class="requiredIcon">*</span></label>
												<input type="text" readonly required name="fullName"
													class="form-control <?php echo (!empty($customerName_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $name; ?>">
												<span class="invalid-feedback"><?php echo $customerName_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Status</label>
												<input type="text" name="customerStatus" readonly class="form-control" value="<?php echo $status; ?>" />
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Customer ID</label>
												<input type="text" readonly name="customerID" class="form-control"
													autocomplete="off" value="<?php echo $id; ?>" />
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-3">
												<label for="vendorDetailsVendorMobile">Contact Number<span
														class="requiredIcon">*</span></label>
												<input type="text" readonly required name="mobile" class="form-control"
													autocomplete="off" value="<?php echo $mobile ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="vendorDetailsVendorEmail">Email*</label>
												<input type="text" readonly required name="email"
													class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $email ?>">
												<span class="invalid-feedback"><?php echo $email_err;?>
											</div>
										</div>
										<div class="form-group">
											<label for="vendorDetailsVendorAddress">Complete Address<span
													class="requiredIcon">*</span></label>
											<input type="text" readonly required name="address"
												class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $address?>">
											<span class="invalid-feedback"><?php echo $address_err;?>
										</div>
								</div>
							</div>
							<a href="view_customers.php">
								<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
							</a>
							</form>
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