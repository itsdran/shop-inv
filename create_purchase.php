<?php
session_start();
// Redirect the user to login page if he is not logged in.
if(!isset($_SESSION['loggedIn'])){
	header('Location: login.php');
	exit();
}
require_once('inc/config/constants.php');
require_once('inc/config/db.php');
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
   
    if(isset($_POST['itemImageItemNumber'])){
		
		$itemImageItemNumber = htmlentities($_POST['itemImageItemNumber']);
		
		$baseImageFolder = '../../data/item_images/';
		$itemImageFolder = '';
		
		if(!empty($itemImageItemNumber)){
			
			// Check if the user has selected an image
			if($_FILES['itemImageFile']['name'] != ''){
				// Both itemNumber and image file given. Hence, proceed to next steps
				
				// Sanitize item number
				$itemImageItemNumber = filter_var($itemImageItemNumber, FILTER_SANITIZE_STRING);
				
				// Check if itemNumber is in DB
				$itemNumberSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
				$itemNumberStatement = $conn->prepare($itemNumberSql);
				$itemNumberStatement->execute(['itemNumber' => $itemImageItemNumber]);
				
				if($itemNumberStatement->rowCount() > 0){
					// Item is in the DB, hence proceed to next steps
					// Check the file .extension
					$arr = explode('.', $_FILES['itemImageFile']['name']);
					$extension = strtolower(end($arr));
					$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
					
					if(in_array($extension, $allowedTypes)){
						// All good so far...
						
						$baseImageFolder = '../../data/item_images/';
						$itemImageFolder = '';
						$fileName = time() . '_' . basename($_FILES['itemImageFile']['name']);
						
						// Create image folder for uploading images
						$itemImageFolder = $baseImageFolder . $itemImageItemNumber . '/';
						if(is_dir($itemImageFolder)){
							// Folder already exists. Hence, do nothing
						} else {
							// Folder does not exist, Hence, create it
							mkdir($itemImageFolder);
						}
						
						$targetPath = $itemImageFolder . $fileName;
						//echo $targetPath;
						//exit();
						
						// Upload file to server
						if(move_uploaded_file($_FILES['itemImageFile']['tmp_name'], $targetPath)){
							
							// Update image url in item table
							$updateImageUrlSql = 'UPDATE item SET imageURL = :imageURL WHERE itemNumber = :itemNumber';
							$updateImageUrlStatement = $conn->prepare($updateImageUrlSql);
							$updateImageUrlStatement->execute(['imageURL' => $fileName, 'itemNumber' => $itemImageItemNumber]);
							
							echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Image uploaded successfully.</div>';
							exit();
							
						} else {
							echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Could not upload image.</div>';
							exit();
						}
						
					} else {
					// Image type is not allowed
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Image type is not allowed. Please select a valid image.</div>';
					exit();
					}
				}
				
			} else {
				// Image file not given
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select an image</div>';
				exit();
			}
		
		} else {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter item number</div>';
			exit();
		}

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
						<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
						<div class="card card-outline-secondary"  style="border-radius: 35px 35px 0 0">
						<div class="card-header"  style="border-radius: 35px 35px 0 0">Purchase Details</div>
							<div class="card-body">
								<div id="purchaseDetailsMessage"></div>
								<form>
								<div class="form-row">
									<div class="form-group col-md-3">
									<label for="purchaseDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control" id="purchaseDetailsItemNumber" name="purchaseDetailsItemNumber" autocomplete="off">
									<div id="purchaseDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
									</div>
									<div class="form-group col-md-3">
									<label for="purchaseDetailsPurchaseDate">Purchase Date<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control datepicker" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" readonly value="2018-05-24">
									</div>
									<div class="form-group col-md-2">
									<label for="purchaseDetailsPurchaseID">Purchase ID</label>
									<input type="text" readonly class="form-control invTooltip" id="purchaseDetailsPurchaseID" name="purchaseDetailsPurchaseID" title="This will be auto-generated when you add a new record" autocomplete="off">
									<div id="purchaseDetailsPurchaseIDSuggestionsDiv" class="customListDivWidth"></div>
									</div>
								</div>
								<div class="form-row"> 
									<div class="form-group col-md-4">
										<label for="purchaseDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
										<input type="text" class="form-control invTooltip" id="purchaseDetailsItemName" name="purchaseDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
									</div>
									<div class="form-group col-md-2">
										<label for="purchaseDetailsCurrentStock">Current Stock</label>
										<input type="text" class="form-control" id="purchaseDetailsCurrentStock" name="purchaseDetailsCurrentStock" readonly>
									</div>
									<div class="form-group col-md-4">
										<label for="purchaseDetailsVendorName">Vendor Name<span class="requiredIcon">*</span></label>
										<select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
										
										<?php 
											require('model/vendor/getVendorNames.php');
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
<<<<<<< Updated upstream
								<button type="button" id="addPurchase" class="btn btn-success">Add Purchase</button>
=======
								<br><br><br><br><br>
								<button type="button" id="addPurchase" style="background-color: #ECAC3D; border-color: #ECAC3D;"class="btn btn-success">Add Purchase</button>
>>>>>>> Stashed changes
								<a href="view_purchase.php">
										<button type="button" class="btn btn-secondary" style="width: 100px;">Back</button>
										</a> 
								<button type="reset" class="btn btn-secondary">Clear</button>
								</form>
							</div> 
						</div>
				</div>
			</div>
		</div>
		</div>
		<br><br><br><br><br><br><br>
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
