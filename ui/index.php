<?php
session_start();
include('../assets/functions.php');
$userID=$_SESSION['hierachy'];
?>
<html>

<head>
	<title>Exam Malpractice :: Home</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/fontawesome-all.min.css" rel="stylesheet">
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200,300,400,700" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
	</head>
<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<aside class="sidebar-left">
				<h1>
					<a href="#" class="logo">
						<img src="images/logo.png" width="200px" height="150px">
					</a>
				</h1>
			<?php echo loadNavigation($userID); ?>
			<a href="logout.php" class="btn btn-success btn-lg btn-block mt-5 w3ls-btn p-1 text-uppercase font-weight-bold">Logout</a>
			</aside>
		</div>
	</div>
	<!--left-fixed -navigation-->
	<!-- header-starts -->
	<header class="header-section">
		<div class="header-left  clearfix">
			<!--logo start-->
			<div class="brand">
				<button id="showLeftPush">
					<i class="fas fa-bars"></i>
				</button>
			</div>
			<!--logo end-->
		</div>
		<div class="header-right">
		</div>
	</header>
	<!-- //header-ends -->
	<!-- main content start-->
	<div id="page-wrapper">
		
		<!-- //banner -->
		<!-- about -->
		<section class="wthree-row py-sm-5 py-3">
			<div class="container py-md-5">
				<div class="py-lg-5 py-3 bg-pricemain text-center">
					<h3 style="margin-top:-120px; color: green;" class="agile-title text-uppercase">Faculty of Physical Sciences</h3><br/> <h4 style="color: green;">Ahmadu Bello University, Zaria.</h4><br/><h4>Exam Malpractice Portal</h4>
				</div>
				<div class="row py-lg-5 pt-md-5 pt-3 d-flex justify-content-center" style="margin-left:60px; margin-right:60px; text-align:justify;">
					<h4>Welcome to the Exam Malpractice Portal, Here you can:</h4> <br>
				</div>
				<div class="row py-lg-5 pt-md-5 pt-3 d-flex justify-content-center" style="margin-left:60px; margin-right:60px; text-align:left;">
					<ul style="list-style-type: disc;">
						<li style="list-style-type: disc;"><b>Add details of the student invovled in examination malpratice</b></li>
						<li style="list-style-type: disc;"><b>Generate the report of the session for further investigation and findings </b></li>
						<li style="list-style-type: disc;"><b>View the details of specific student</b></li>
						<li></li>
					</ul>
				</div>
			</div>
		</section>
		<div class="footer py-md-5 pt-sm-3 pb-sm-5">
			<div class="cpy-right text-center pb-sm-0 pb-5">
				<p>© 2019 DCS Project</p>
			</div>
		</div>
	</div>
	<script src="js/jquery-2.2.3.min.js"></script>
	<script src="js/classie.js "></script>
	<script src="js/move-top.js "></script>
	<script src="js/easing.js "></script>
	<script src="js/SmoothScroll.min.js "></script>
	<script src="js/counter.js"></script>
	<script src="js/bootstrap.js ">
	</script>
</body>

</html>