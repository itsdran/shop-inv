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
 
// Processing form data when form is submitted
if(isset($_POST["sProviderID"]) && !empty($_POST["sProviderID"])){
    // Get hidden input value
    $id = $_POST["sProviderID"];
    $mobile = $_POST["mobile"];
    $status = $_POST["sProviderStatus"];
    
	// Validate company name
    $input_companyName = trim($_POST["companyName"]);
    if(empty($input_companyName)){
        $name_err = "Please enter a company name.";
    } elseif(!filter_var($input_companyName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $companyName = $input_companyName;
    }

    // Validate vendor name
    $input_vendorName = trim($_POST["vendorName"]);
    if(empty($input_vendorName)){
        $vendorName_err = "Please enter a handler name.";
    } elseif(!filter_var($input_vendorName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $vendorName_err = "Please enter a valid name.";
    } else{
        $vendorName = $input_vendorName;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter email.";     
    } 
    else{
        $email = $input_email;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter the company address.";     
    }
    else{
        $address = $input_address;
    }
      
    // Check input errors before inserting in database
    if(empty($name_err) && empty($vendorName_err) && empty($mobile_err) && empty($address_err)  && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE stockprovider SET vendorName=?, companyName=?, email=?, mobile=?, status=?, address=? WHERE sProviderID=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_vendorName, $param_companyName, $param_email, $param_mobile, $param_status, $param_address, $param_id);
            
            // Set parameters
            $param_companyName = $companyName;
			$param_vendorName = $vendorName;
            $param_email= $email;
            $param_mobile = $mobile;
            $param_status = $status;
            $param_address = $address;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: view_stockprovider.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
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
                    $companyName = $row['companyName']; 
                    $vendorName = $row['vendorName'];
                    $mobile = $row['mobile'];
                    $email = $row['email'];
                    $status = $row['status'];
                    $address = $row['address'];
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
<body>
<<<<<<< Updated upstream
	<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<a style="text-decoration: none; color:white" href="index.html"><img src="assets/img/logo-w.png" style="width:60px">&nbsp Thrifted Goods PH | Inventory </a>
		<a class="d-md-inline-block" style="color:white; margin-left: 830px" name=sid>Welcome <?php echo $_SESSION['fullName']; ?> &nbsp | <b>
			</b></a>
		<a class="d-md-inline-block" style="color:white" href="model/login/logout.php">&nbspLog Out</a>
        
	</nav>
=======
<?php include "header_web.html"?>
>>>>>>> Stashed changes
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
												<input type="text" required name="companyName" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $companyName; ?>">
												<span class="invalid-feedback"><?php echo $name_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Status</label>
												<select name="sProviderStatus" class="form-control chosenSelect" value="<?php echo $status; ?>">
													<?php include('statusList.html'); ?>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label>Handler Fullname*</label>
												<input type="text" required name="vendorName"
													class="form-control <?php echo (!empty($vendorName_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $vendorName; ?>">
												<span class="invalid-feedback"><?php echo $vendorName_err;?>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-3">
												<label for="vendorDetailsVendorMobile">Contact Number<span
														class="requiredIcon">*</span></label>
												<input type="tel" required name="mobile"
													class="form-control <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>"
													autocomplete="off" value="<?php echo $mobile; ?>">
												<span class="invalid-feedback"><?php echo $mobile_err;?>
											</div>
											<div class="form-group col-md-4">
												<label for="vendorDetailsVendorEmail">Email*</label>
												<input type="text" required name="email"
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
											<input type="text" required name="address"
												class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"
												autocomplete="off" value="<?php echo $address; ?>">
											<span class="invalid-feedback"><?php echo $address_err;?>
										</div>
<<<<<<< Updated upstream
										<input type="submit" class="btn btn-primary" value="Add Stock Provider">
=======
										<br><br><br>
										<input type="submit" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success" value="Update Stock Provider">
>>>>>>> Stashed changes
										<a href="view_stockProvider.php">
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