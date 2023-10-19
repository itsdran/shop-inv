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
$itemNumber = $itemName  = $description = $quantity = $itemPrice = $itemStatus = $sid = "";
$itemNumber_err = $name_err = $itemDesc_err = $quantity_err = $itemPrice_err = $discount_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$itemStatus = $_POST['itemStatus'];  

	$itemNumber_validate = $_POST['itemNumber'];
  	$sql = "SELECT * FROM item WHERE itemNumber='$itemNumber_validate'";
  	$results = mysqli_query($link, $sql);
    // Validate item name
    $input_itemName = trim($_POST["itemName"]);
    if(empty($input_itemName)){
        $name_err = "Please enter an item name.";
    } elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $itemName = $input_itemName;
    }

    // Validate item descriptiom
    $input_itemDesc = trim($_POST["description"]);
    if(empty($input_itemDesc)){
        $itemDesc_err = "Please enter a description.";     
    } else{
        $description = $input_itemDesc;
    }
    
    // Validate item number
    $input_itemNumber = trim($_POST["itemNumber"]);
    if(empty($input_itemNumber)){
        $itemNumber_err = "Please enter the item number.";     
    } elseif(!ctype_digit($input_itemNumber)){
        $itemNumber_err = "Please enter a positive integer value.";
    } elseif(mysqli_num_rows($results) > 0){
    	$itemNumber_err = "Item number already exists in DB. Please try again.";
    }
    else{
        $itemNumber = $input_itemNumber;
    }

    // Validate quantity
    $input_quantity = trim($_POST["quantity"]);
    if(empty($input_quantity)){
        $quantity_err = "Please enter the item quantity.";     
    } elseif(!ctype_digit($input_quantity)){
        $quantity_err = "Please enter a positive integer value.";
    } 
    else{
        $quantity= $input_quantity;
    }

    // Validate price
    $input_itemPrice = trim($_POST["itemPrice"]);
    if(empty($input_itemPrice)){
        $itemPrice_err = "Please enter the item quantity.";     
    } elseif(!ctype_digit($input_itemPrice)){
        $itemPrice_err = "Please enter a positive integer value.";
    } 
    else{
        $itemPrice = $input_itemPrice;
    }

	// Validate discount
    $input_discount = trim($_POST["discount"]);
    if(!ctype_digit($input_discount)){
        $discount_err = "Please enter a positive integer value.";
    } 
    else{
        $discount = $input_discount;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($itemDesc_err) && empty($itemNumber_err) && empty($quantity_err) && empty($itemPrice_err) && empty($discount_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO item (itemNumber, itemName, description, status, stock, unitPrice, discount) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_itemNumber, $param_itemName, $param_description, $param_status, $param_quantity, $param_itemPrice, $param_discount);
            
            // Set parameters
            $param_itemNumber = $itemNumber;
            $param_itemName = $itemName;
            $param_description = $description;
            $param_status = $itemStatus;
            $param_quantity = $quantity;
            $param_itemPrice = $itemPrice;
            $param_discount = $discount;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo '<div class="alert alert-success" style="margin-bottom:0px;"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
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
<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<a style="text-decoration: none; color:white" href="index.html"><img src="assets/img/logo-w.png" style="width:60px">&nbsp Thrifted Goods PH | Inventory </a>
		<a class="d-md-inline-block" style="color:white; margin-left: 1350px" name=sid>Welcome, <?php echo $_SESSION['fullName']; ?> &nbsp | </a>
		<a class="d-md-inline-block" style="color:white" href="model/login/logout.php"> Log Out</a>
		
	</nav>
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
						<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
						<div class="card card-outline-secondary" style="border-radius: 35px 35px 0 0 ">
							<div class="card-header" style="border-radius: 35px 35px 0 0"  >Item Details</div>
							<div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Item</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#itemImageTab">Upload Image</a>
								</li>
							</ul>
							
							<!-- Tab panes for item details and image sections -->
							<div class="tab-content">
								<div id="itemDetailsTab" class="container-fluid tab-pane active" >
									<br>
									<!-- Div to show the ajax message from validations/db submission -->
									<div id="itemDetailsMessage"></div>
									<form method="post">
										<div class="form-row">
										<div class="form-group col-md-3" style="display:inline-block">
											<label name="itemNumber">Item Number<span class="requiredIcon">*</span></label>
											<input type="text" name="itemNumber" class="form-control <?php echo (!empty($itemNumber_err)) ? 'is-invalid' : ''; ?>" id="itemDetailsItemNumber" autocomplete="off">
											<span class="invalid-feedback"><?php echo $itemNumber_err;?></span>
										</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
											<label for="itemDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
											<input type="text" name="itemName" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="itemDetailsItemName" autocomplete="off" >
											<span class="invalid-feedback"><?php echo $name_err;?></span>
											</div>
											<div class="form-group col-md-2">
											<label for="itemStatus">Status</label>
											<select id="itemDetailsStatus" name="itemStatus" class="form-control chosenSelect">
												<?php include('statusList.html'); ?>
											</select>
											</div>
										</div>
										<div class="form-row">
										<div class="form-group col-md-6" style="display:inline-block">
											<label for="itemDetailsDescription">Description</label> 
											<textarea  rows="7" name="description" class="form-control <?php echo (!empty($itemDesc_err)) ? 'is-invalid' : ''; ?>" id="itemDetailsDescription" value="<?php echo $description; ?>"></textarea>
										<span class="invalid-feedback"><?php echo $itemDesc_err;?></span>
										</div>
										</div>
										<div class="form-row">
										<div class="form-group col-md-3">
											<label for="itemDetailsDiscount">Discount %</label>
											<input type="text" class="form-control <?php echo (!empty($itemDesc_err)) ? 'is-invalid' : ''; ?>" value="0" name="discount" id="itemDetailsDiscount">
											<span class="invalid-feedback"><?php echo $discount_err;?></span>
										</div>
										<div class="form-group col-md-3">
											<label for="itemDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
											<input type="number" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  value="0" name="quantity" id="itemDetailsQuantity">
											<span class="invalid-feedback"><?php echo $quantity_err;?></span>
										</div>
										<div class="form-group col-md-3">
											<label name="itemPrice">Unit Price<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control <?php echo (!empty($itemPrice_err)) ? 'is-invalid' : ''; ?>" value="0" name="itemPrice" id="itemDetailsUnitPrice">
											<span class="invalid-feedback"><?php echo $itemPrice_err;?></span>
										</div>
										<div class="form-group col-md-3">
											<div id="imageContainer"></div>
										</div>
										</div>
										<input type="submit" class="btn btn-primary" value="Add Item">
										<a href="view_item.php">
										<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
										</a> 
										<button type="reset" class="btn btn-secondary" id="itemClear">Clear</button>
									</form>
								</div>
								<div id="itemImageTab" class="container-fluid tab-pane fade">
									<br>
									<div id="itemImageMessage"></div>
									<p>You can upload an image for a particular item using this section.</p> 
									<p>Please make sure the item is already added to database before uploading the image.</p>
									<br>							
									<br><br><br><br><br><br><br><br>
									<form name="imageForm" id="imageForm" method="post">
									<div class="form-row">
									
										<div class="form-group col-md-3" style="display:inline-block">
										
										<label for="itemImageItemNumber">Item Number<span class="requiredIcon">*</span></label>
										<input type="text" readonly class="form-control" name="itemImageItemNumber" id="itemImageItemNumber" autocomplete="off" value="<?php echo $itemNumber; ?>">
										<div id="itemImageItemNumberSuggestionsDiv" class="customListDivWidth"></div>
										</div>
										<div class="form-group col-md-4">
											<label for="itemImageItemName">Item Name</label>
											<input type="text" readonly class="form-control" name="itemImageItemName" id="itemImageItemName"  value="<?php echo $itemName; ?>">
										</div>
									</div>
									<br>
									<div class="form-row">
										<div class="form-group col-md-7">
											<label for="itemImageFile">Select Image ( <span class="blueText">jpg</span>, <span class="blueText">jpeg</span>, <span class="blueText">gif</span>, <span class="blueText">png</span> only )</label>
											<input type="file" class="form-control-file btn btn-dark" id="itemImageFile" name="itemImageFile">
										</div>
									</div>
									
									<br>
<<<<<<< Updated upstream
									<button type="button" id="updateImageButton" class="btn btn-primary">Upload Image</button>
									<button type="button" id="deleteImageButton" class="btn btn-danger">Delete Image</button>
									<button type="reset" class="btn">Clear</button>
=======
									<button type="button" id="updateImageButton" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success">Upload Image</button>
									<button type="reset" class="btn btn-secondary">Clear</button>
									
>>>>>>> Stashed changes
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
		<footer class="footer fixed-bottom">
			<div class="container">
			<p class="text-center text-white">Copyright &copy; Inventory System <?php echo date('Y'); ?></p>
			</div>
		</footer>
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
