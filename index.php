<?php
	session_start();
	
	// Check if user is already logged in
	if(isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}
	
	require_once "config.php";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="TGPH">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

    <!--  ICON -->
    <link rel="icon" href="assets/img/logo-w.png" type="image/x-icon"/>

	<title>TGPH -Thrift Shop</title>

</head>
<style>
.navbar{

}
</style>
<body data-spy="scroll" data-target=".navbar" class="has-loading-screen" data-bg-parallax="scroll" data-bg-parallax-speed="3">
    <div class="ts-page-wrapper" id="page-top">

        <header id="ts-hero" class="ts-full-screen">

            <nav class="navbar navbar-expand-lg navbar-dark fixed-top ts-separate-bg-element" data-bg-color="#1a1360">
                <div class="container">
                     <img style="width: 150px;" src="assets/img/logo-w.png" alt="">
                    <a class="navbar-brand" href="#page-top">
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="margin-right: 122px !important;">
                            <div class="navbar-nav ml-auto" >
                                <a class="nav-item nav-link active ts-scroll" href="index.html">Home <span class="sr-only">(current)</span></a>
                                <a class="nav-item nav-link ts-scroll" href="">Items</a>
                                <a class="nav-item nav-link ts-scroll" href="login.php">Inventory</a>
                                
                            </div>
                        </div>
                        <br><br>
                        
                    </a>
                   
                </div>
            </nav>

            <div class="container align-self-center">
                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <br><br><br><br><br><br><br><br>
                        <h3 class="ts-opacity__50">Manage your items here</h3>
                        <h1>Thrifted<br/>Goods PH</h1>
                        <a href="#" class="btn btn-light btn-lg ts-scroll">Purchase Now</a>
                    </div>
                    <div class="col-sm-5 d-none d-sm-block">
                        <div class="owl-carousel text-center" data-owl-nav="1" data-owl-loop="1">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Home page" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Sections" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Menu" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Products listing" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Filter" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Product Detail page" style="margin-top: 120px; width:250px!important;">
                            <img src="assets/img/img-phone4-screen.png" class="d-inline-block mw-100 p-md-5 p-lg-0 ts-width__auto" alt="TGPH Cart page" style="margin-top: 120px; width:250px!important;">                            
                        </div>
                    </div>
                </div>
            </div>

            <div id="ts-dynamic-waves" class="ts-background" data-bg-color="#1a1462">
                <svg class="ts-svg ts-parallax-element" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path class="ts-dynamic-wave" d="" data-wave-color="#dd4b5b" data-wave-height=".6" data-wave-bones="4" data-wave-speed="0.15"/>
                </svg>
                <svg class="ts-svg" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path class="ts-dynamic-wave" d="" data-wave-color="#fff" data-wave-height=".2" data-wave-bones="6" data-wave-speed="0.2"/>
                </svg>
            </div>
        </header>
        <main id="ts-content">            
            <footer id="ts-footer">
                <div class="container">
                    <div class="text-center py-4">
                        <p>©2021 Thrifted Goods PH, All Rights Reserved</p>
                    </div>
                </div>
            </footer>
    </div>
    <script>
        if( document.getElementsByClassName("ts-full-screen").length ) {
            document.getElementsByClassName("ts-full-screen")[0].style.height = window.innerHeight + "px";
        }
    </script>
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>    
	<script src="assets/js/isInViewport.jquery.js"></script>
	<script src="assets/js/jquery.particleground.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/scrolla.jquery.min.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/jquery-validate.bootstrap-tooltip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js"></script>
    <script src="assets/js/jquery.wavify.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
