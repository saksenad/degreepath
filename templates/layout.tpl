<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- start: Meta -->
	  <meta charset="utf-8">
	  <title>DegreePath</title>
	  <!-- end: Meta -->
	
	  <!-- start: Mobile Specific -->
	  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	  <!-- end: Mobile Specific -->

    <!-- start: CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
	  <link href="css/style.css" rel="stylesheet">
	  <link href="css/custom.css" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700">
	  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif">
	  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Boogaloo">
	  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Economica:700,400italic">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>
	  <!-- end: CSS -->

    <!-- start: Java Script -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/degreepath.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/flexslider.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/jquery.cslider.js"></script>
    <script src="js/slider.js"></script>
    <script defer="defer" src="js/custom.js"></script>
    <!-- end: Java Script -->

  </head>
  <body>

    <!--start: Header -->
	  <header>
		
		  <!--start: Container -->
		  <div class="container">
			
			  <!--start: Row -->
			  <div class="row">
					
				  <!--start: Logo -->
				  <div class="logo span3">
						
					  <a class="brand" href="#"><img src="img/logo.png" alt="Logo"></a>
						
				  </div>
				  <!--end: Logo -->
					
				  <!--start: Navigation -->
				  <div class="span9">
					
					  <div class="navbar navbar-inverse">
			      		<div class="navbar-inner">
			            		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			              		<span class="icon-bar"></span>
			              		<span class="icon-bar"></span>
			              		<span class="icon-bar"></span>
			            		</a>
			            		<div class="nav-collapse collapse">
			              		<ul class="nav">
			                			<li class="active"><a href="#">Home</a></li>
			                			<li><a href="#">About</a></li>
			                			<li><a href="#">Contact</a></li>
			                			<li class="dropdown">
			                  			<a href="#" class="dropdown-toggle" data-toggle="dropdown">George P. Burdell <b class="caret"></b></a>
			                  			<ul class="dropdown-menu">
			                    				<li><a href="#">Manage Profile</a></li>
			                    				<li class="divider"></li>
			                    				<li><a href="#">Log-out</a></li>
			                  			</ul>
			                			</li>
			              		</ul>
			            		</div>
			          	</div>
			        	</div>
					
				  </div>	
				  <!--end: Navigation -->
					
			  </div>
			  <!--end: Row -->
			
		  </div>
		  <!--end: Container-->			
			
	  </header>
	  <!--end: Header-->
	
    <div class="content">{block name=body}{/block}</div>

  </body>
</html>
