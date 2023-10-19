<?php
	session_start();
	// Check if user is already logged in
	if(isset($_SESSION['loggedIn'])){
		header('Location: view_item.php');
	}
	
	require_once "config.php";
	require_once('header.html');
?>
  <body style= background-color:#dbe6fd>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top nav-color nav2 d-flex flex-column flex-md-row justify-content-between">
		<a style="text-decoration: none; color:white" href="index.php"><img src="assets/img/logo-w.png" style="width:60px">&nbsp Thrifted Goods PH | Inventory </a>
	</nav>
<?php
// Variable to store the action (login, register, passwordReset)
$action = '';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
		if($action == 'register'){
?>
			<div class="container">
			  <div class="row justify-content-center">
			  <div class="col-sm-12 col-md-5 col-lg-5">
				<div class="card" style="margin-top: 50px; border-radius: 30px;">
				  <div class="card-header"  style="border-radius: 30px 30px 0 0;">
					Register
				  </div>
				  <div class="card-body">
					<form action="">
					<div id="registerMessage"></div>
					  <div class="form-group">
						<label for="registerFullName">Name<span class="requiredIcon">*</span></label>
						<input type="text" class="form-control" id="registerFullName" name="registerFullName">
						<!-- <small id="emailHelp" class="form-text text-muted"></small> -->
					  </div>
					   <div class="form-group">
						<label for="registerUsername">Username<span class="requiredIcon">*</span></label>
						<input type="email" class="form-control" id="registerUsername" name="registerUsername" autocomplete="on">
					  </div>
					  <div class="form-group">
						<label for="registerPassword1">Password<span class="requiredIcon">*</span></label>
						<input type="password" class="form-control" id="registerPassword1" name="registerPassword1">
					  </div>
					  <div class="form-group">
						<label for="registerPassword2">Re-enter password<span class="requiredIcon">*</span></label>
						<input type="password" class="form-control" id="registerPassword2" name="registerPassword2">
					  </div>
					  <a href="login.php" class="btn btn-primary"  style="background-color: #ECAC3D; border-color: #ECAC3D;">Login</a>
					  <button type="button" id="register" class="btn btn-success"  style="background-color: #ECAC3D; border-color: #ECAC3D;">Register</button>
					  <a href="login.php?action=resetPassword" class="btn btn-warning"  style="background-color: #ECAC3D; border-color: #ECAC3D; color: white;">Reset Password</a>
					  <button type="reset" class="btn btn-secondary">Clear</button>
					</form>
				  </div>
				</div>
				</div>
			  </div>
			</div>
<?php
			require 'footer.php';
			echo '</body></html>';
			exit();
		} elseif($action == 'resetPassword'){
?>
			<div class="container">
			  <div class="row justify-content-center">
			  <div class="col-sm-12 col-md-5 col-lg-5">
				<div class="card" style="margin-top: 50px; margin-bottom: 30px; border-radius: 30px;">
				  <div class="card-header" style="border-radius: 30px 30px 0 0;">
					Reset Password
				  </div>
				  <div class="card-body">
					<form action="">
					<div id="resetPasswordMessage"></div>
					  <div class="form-group">
						<label for="resetPasswordUsername">Username</label>
						<input type="text" class="form-control" id="resetPasswordUsername" name="resetPasswordUsername">
					  </div>
					  <div class="form-group">
						<label for="resetPasswordPassword1">New Password</label>
						<input type="password" class="form-control" id="resetPasswordPassword1" name="resetPasswordPassword1">
					  </div>
					  <div class="form-group">
						<label for="resetPasswordPassword2">Confirm New Password</label>
						<input type="password" class="form-control" id="resetPasswordPassword2" name="resetPasswordPassword2">
					  </div>
					  <a href="login.php" class="btn btn-primary" style="background-color: #ECAC3D; border-color: #ECAC3D;">Login</a>
					  <a href="login.php?action=register" class="btn btn-success" style="background-color: #ECAC3D; border-color: #ECAC3D;">Register</a>
					  <button type="button" id="resetPasswordButton" class="btn btn-warning" style="background-color: #ECAC3D; border-color: #ECAC3D; color:white;">Reset Password</button>
					  <button type="reset" class="btn btn-secondary">Clear</button>
					</form>
				  </div>
				</div>
				</div>
			  </div>
			</div>
			<br><br><br>
<?php
			require 'footer.php';
			echo '</body></html>';
			exit();
		}
	}	
?><br><br><br><br>
	<!-- Default Page Content (login form) -->
	<br><br><br><br>
    <div class="container" style="margin-bottom: 139px; ">
      <div class="row justify-content-center" style="margin-top: 50px; ">
	  <div class="col-sm-12 col-md-5 col-lg-5" >
		<div class="card" style="height: 350px; border-radius: 30px;">
		  <div class="card-header" style="border-radius: 30px 30px 0 0;">
			Login
		  </div>
		  <div class="card-body" style="height: 520px;">
			<form action="">
			<div id="loginMessage"></div>
			  <div class="form-group">
				<label for="loginUsername">Username</label>
				<input type="text" class="form-control" id="loginUsername" name="loginUsername">
			  </div>
			  <div class="form-group" style="margin-top: 30px;">
				<label for="loginPassword">Password</label>
				<input type="password" class="form-control" id="loginPassword" name="loginPassword">
			  </div>
			  <br>
			  <button type="button" id="login" class="btn btn-primary" style="background-color: #ECAC3D; border-color: #ECAC3D;">Login</button>
			  <a href="login.php?action=register" class="btn btn-success" style="background-color: #ECAC3D; border-color: #ECAC3D;">Register</a>
			  <a href="login.php?action=resetPassword" class="btn btn-warning" style="background-color: #ECAC3D; border-color: #ECAC3D; color: white">Reset Password</a>
			  <button type="reset" class="btn btn-secondary">Clear</button>
			</form>
		  </div>
		</div>
		</div>
      </div>
    </div><br><br><br><br>
<?php
	require 'footer.php';
?>
  </body>
</html>