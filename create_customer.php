<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$customerName = $email = $mobile = $address = $status = $sid ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$customerStatus = $_POST['customerStatus'];

	$mobile = $_POST['mobile']; 

    // Validate customer
    $input_customerName = trim($_POST["customerName"]);
    if(empty($input_customerName)){
        $customerName_err = "Please enter a customer name.";
    } elseif(!filter_var($input_customerName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $customerName_err = "Please enter a valid name.";
    } else{
        $customerName = $input_customerName;
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
        $address_err = "Please enter the customer address.";     
    }
    else{
        $address = $input_address;
    }
    
    // Check input errors before inserting in database
    if(empty($customerName_err) && empty($mobile_err) && empty($address_err)  && empty($email_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO customer (fullname, email, mobile, address, status) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_customerName, $param_email, $param_mobile, $param_address, $param_customerStatus);
            
            // Set parameters
            $param_customerName = $customerName;
            $param_email= $email;
            $param_mobile = $mobile;
            $param_address = $address;
            $param_customerStatus = $customerStatus;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo '<div class="alert alert-success" style="margin-bottom:0px;"><button type="button" class="close" data-dismiss="alert">&times;</button>Record added to database.</div>';
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
	

    // Close connection
    mysqli_close($link);
}

		
?>
<<<<<<< Updated upstream
<!DOCTYPE html>
<html>
	<head>
		<title> Inventory System </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    	<!-- Datatables CSS -->
		<link rel="stylesheet" type="text/css" href="vendor/DataTables/datatables.css">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<style>
		body{
		background-color: #dbe6fd;
		}

		.footer {
		  position: static;
		  background-color: maroon;
		  margin-top: 90px;
		  margin-bottom: 0px;
		  width: 100%;
		  height: 60px; /* Set the fixed height of the footer here */
		  line-height: 60px; /* Vertically center the text there */
		}
		
		.nav2{
		background-color: white;
		height: 85px;
		width:100%;
		position: static;
		float: right;
		display: inline-block;
		}

		#bodyContainer{
		width:70%;
		background-repeat: no-repeat;
		display: inline;
		background-color: blue;
		float: right;
		}

		#ulsidebar{
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

		#content{
		}

		.sideLi a {
		height: 60px;
		display: block;
		color: white;
		padding: 20px;
		text-decoration: none;
		}

		.sideLi a.active {
		  background-color:  #47597E;
		  color: white;
		}

		.sideLi a:hover:not(.active) {
		  background-color: #DBE6FD;
		  color: #293B5F;
		}

		#mainPanel{
		top: 40px;
		background-color: white;
		width: 97%;
		right: 0px;
		bottom:0px;
		float: right;
		height: 600px;
		position: relative;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		div{

		}
		.row{
		margin:auto;
		width: 100%;
		}
		.column1{
		width:18%;
		margin-left: 30px;

		}
		.column2{
		margin-top: 40px;
		width: 75%;
		margin-left: 30px;
		}

		.column3{
		width:40%;

		}
		.column4{
		width:58%;
		margin-left: 2%;

		}
		h2{
		margin-top: 30px;
		color: #293b5f;
		font-family: "Times New Roman", Times, serif;
		}

		td{
		height: 30px;
		color: white;
		text-align: left;
		font-size: 13px;
		}
		.c1{
		width:25%;
		}
		.c2 .c4{
		width: 5%;
		}
		.c3{
		width: 35%;
		}
		.c5 .c6 .c7{
		width: 10%;
		}

		.viewInfoDiv {
		margin: auto;
		border: 1px solid #47597E;
		width: 90%;
		height: 490px;
		}

		.viewInfoBg {
		width:100%;
		height: 450px;
		background-color: #B2AB8C;
		float: right;
		}

		.font{
		font-family: Serif;
		font-size: 18px;
		}

	</style>

	<body>
			<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
				<img src="header.png" style="margin-left: 0px; width">
				<a class="py-2 d-none d-md-inline-block font" name = sid>Welcome Admin<b><?php echo $sid; ?> </b></a>
			</nav>
			<div class="row">
				<div class="column1">
					<ul id="ulsidebar"><b>
					  <li class="sideLi"><a href="view_item.php">PRODUCTS</a></li>
					  <li class="sideLi"><a href="view_purchase.php">PURCHASE</a></li>
					  <li class="sideLi"><a href="view_stockProvider.php">STOCK PROVIDERS</a></li>
					  <li class="sideLi"><a href="view_sales.php">SALES</a></li>
					  <li class="sideLi"><a class="active" href="view_customers.php">CUSTOMER</a></li>
					  <li class="sideLi"><a href="view_reports.php">REPORTS</a></li>
					</ul></b>
				</div>
				<div class="column2">
						<div class="tab-content" id="v-pills-tabContent">
						  <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
							<div class="card card-outline-secondary">
							  <div class="card-header" >Customer Details</div>
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
									  <div id="vendorDetailsMessage"></div>
										 <form method="post"> 
										  <div class="form-row">
=======
<body>
<?php include "header_web.html"?>
	<div class="row">
		<div class="column1">
			<ul class="sideLi" id="ulsidebar"><b>
					<li><a class="navs" href="view_item.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Products.png"> PRODUCTS </a> </li>
					<li><a class="navs" href="view_purchase.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Purchase Order.png"> PURCHASE </a></li>
					<li><a class="navs" href="view_stockProvider.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Stock Provider.png"> STOCK PROVIDERS </a></li>
					<li><a class="navs" href="view_sales.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Sales.png"> SALES </a></li>
					<li><a class="current" href="view_customers.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Customer.png"> CUSTOMER </a></li>
					<li><a class="navs" href="view_reports.php"><img style="vertical-align: bottom;" width="30px" alt="Brand" src="assets/img/Report.png"> REPORTS </a></li>
			</ul></b>
		</div>
			<div class="column2">
					<div class="tab-content roundContainer" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
						<div class="card card-outline-secondary" style="border-radius: 35px 35px 0 0 ">
							<h2 class="card-header" style="background-color: transparent;">Customer Details</h2>
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
									<div id="vendorDetailsMessage"></div>
										<form method="post"> 
										<div class="form-row">
										<div class="form-group col-md-6">
											<label for="vendorDetailsVendorFullName">Full Name<span class="requiredIcon">*</span></label>
											<input type="text" required name="customerName" class="form-control <?php echo (!empty($customerName_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" >
											<span class="invalid-feedback"><?php echo $customerName_err;?>
										</div>
										<div class="form-group col-md-2">
											<label for="vendorDetailsStatus">Status</label>
											<select name="customerStatus" class="form-control chosenSelect">
												<?php include('statusList.html'); ?>
											</select>
										</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-3">
											<label for="vendorDetailsVendorMobile">Contact Number<span class="requiredIcon">*</span></label>
											<input type="text" required name="mobile" class="form-control" autocomplete="off" >
											</div>
>>>>>>> Stashed changes
											<div class="form-group col-md-6">
											  <label for="vendorDetailsVendorFullName">Full Name<span class="requiredIcon">*</span></label>
											  <input type="text" required name="customerName" class="form-control <?php echo (!empty($customerName_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" >
                            					<span class="invalid-feedback"><?php echo $customerName_err;?>
											</div>
											<div class="form-group col-md-2">
												<label for="vendorDetailsStatus">Status</label>
												<select name="customerStatus" class="form-control chosenSelect">
													<?php include('statusList.html'); ?>
												</select>
											</div>
										  </div>
										  <div class="form-row">
											  <div class="form-group col-md-3">
												<label for="vendorDetailsVendorMobile">Contact Number<span class="requiredIcon">*</span></label>
												<input type="text" required name="mobile" class="form-control" autocomplete="off" >
											  </div>
											  <div class="form-group col-md-6">
												<label for="vendorDetailsVendorEmail">Email*</label>
												<input type="text" required name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" >
                            					<span class="invalid-feedback"><?php echo $email_err;?>
											</div>
										  </div>
										  <div class="form-group">
											<label for="vendorDetailsVendorAddress">Complete Address<span class="requiredIcon">*</span></label>
											<input type="text" required name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" >
                            					<span class="invalid-feedback"><?php echo $address_err;?>
										  </div>
										</div>
<<<<<<< Updated upstream
										  </div>					  
										  <input type="submit" class="btn btn-primary" value="Add Customer">
										  <a href="view_stockProvider.php">
										    <button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
										  </a> 
										  <button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
=======
										</div>
										<div class="form-group">
										<label for="vendorDetailsVendorAddress">Complete Address<span class="requiredIcon">*</span></label>
										<input type="text" required name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" >
											<span class="invalid-feedback"><?php echo $address_err;?>
										</div>
									</div>
									<br><br><br>
										</div>					  
										<input type="submit" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success" value="Add Customer">
										<a href="view_customers.php">
										<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
										</a> 
										<button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
									</form>
>>>>>>> Stashed changes
										</form>
										 </form>
									</div>
								</div>
							  </div> 
						  </div>
					</div>
				</div>
			</div>
<<<<<<< Updated upstream
			</div>
			 <!-- Footer -->
			<footer class="footer fixed-bottom">
			  <div class="container">
				<p class="text-center text-white">Copyright &copy; Inventory System <?php echo date('Y'); ?></p>
			  </div>
			</footer>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		   
=======
		</div>
		</div>
			<!-- Footer -->
			<br><br><br><br><br><br><br><br><br>
<?php include "footer.php"?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
>>>>>>> Stashed changes

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
