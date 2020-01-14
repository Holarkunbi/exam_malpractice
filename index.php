<?php
session_start();
include('assets/functions.php');
global $con;
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	//$x = loginValidate($username,$password);
	$sql = mysqli_query($con, "SELECT * FROM tbl_login WHERE username='$username' && password='$password'") or die(mysql_error());
	$row=mysqli_fetch_array($sql);
	 $userID = $row['hierachy'];
	echo $_SESSION['hierachy'] = $userID;
	if (mysqli_num_rows($sql))
		header("Location: ui/");
		//echo "success";
	else
		echo "Invalid Username or Password";
}
?>
<html>

<head>
	<title>Exam Malpractice :: Login</title>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- font-awesome icons -->
	<link href="css/fontawesome-all.min.css" rel="stylesheet">
	<!-- //Custom Theme files -->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
	<!-- //side nav css file -->
	<!--webfonts-->
	<!-- logo -->
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<!-- titles -->
	<link href="//fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200,300,400,700" rel="stylesheet">
	<!-- body -->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
	<!--//webfonts-->
</head>
<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left">
				<h1>
					<a href="#" class="logo">
						<img src="images/logo.png" width='200px' height='150px'>
					</a>
				</h1>

				<button type="button" class="btn btn-success btn-lg btn-block mt-5 w3ls-btn p-1 text-uppercase font-weight-bold" data-toggle="modal"
				    aria-pressed="false" data-target="#exampleModal">
					Login
				</button>
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
					<h3 style="margin-top:-120px; color: green;" class="agile-title text-uppercase">Faculty of Physical Sciences</h3><br/> <h4 style="color: green;">Ahmadu Bello University, Zaria.</h4><br/><h2>Exam Malpractice Portal</h2>
				</div>
				<div class="row py-lg-5 pt-md-5 pt-3 d-flex justify-content-center" style="margin-left:60px; margin-right:60px; text-align:justify;">
					<p><h4><b>What are condisered Examination Malpractice as stated by the University :</b></h4><br>
						<ul style="list-style-type:disc;">
							<li style="list-style-type: disc;">
								Cheating, Spying or a student allowing his/her work to be copied by another student.
							</li>
							<li style="list-style-type:disc;">Use of material relevant to the examination including textbooks, handsets or other electronic devices in the examination hall</li>
							<li style="list-style-type:disc;">Refusal to complete examination malpratice form when required to do so</li>
							<li style="list-style-type:disc;">Illegal possession of University Examination Booklet </li>
							<li style="list-style-type:disc;">Fore knowledge of examination questions</li>
							<li style="list-style-type:disc;">Possession /destruction of materials in the examination hall relevant to the been examined</li>
						</ul>
					</p>
					
				</div>
			</div>
		</section>
		<!-- //about -->
		<!-- about-bottom -->
		<!-- //about bottom -->
		<!-- stats -->
		<!-- //stats -->

		<!-- services bottom -->
		<!-- //services bottom -->
		<!-- slide -->
		<!-- //slide -->
		<!-- footer -->
		<div class="footer py-md-5 pt-sm-3 pb-sm-5">
			<div class="cpy-right text-center pb-sm-0 pb-5">
				<p>&copy; 2019 DCS Project</p>
			</div>
		</div>
		<!-- //footer -->
		<!-- login and register modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background: green; ">
						<h5 class="modal-title" id="exampleModalLabel">Login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<center><img src="images/logo.png" width="200px" height="200px" class="img-fluid" /></center>
						<form action="" method="post" class="p-3">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Username</label>
								<input type="text" class="form-control" placeholder="Enter Username" name="username" id="recipient-name" required="">
							</div>
							<div class="form-group">
								<label for="password" class="col-form-label">Password</label>
								<input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required="">
							</div>
							<div class=" btn btn-success">
								<input type="submit" name="submit" class="form-control btn-success" value="Login">
							</div>
							<div class="row sub-w3l my-3">
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<!-- //login and register modal -->
	</div>
	<!-- js-->
	<script src="js/jquery-2.2.3.min.js"></script>
	<!-- js-->

	<!-- for toggle left push menu script -->
	<script src="js/classie.js "></script>
	
	<script src="js/SmoothScroll.min.js "></script>
	<!-- //smooth-scrolling-of-move-up -->
	<script src="js/counter.js"></script>
	<!-- //stats -->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js ">
	</script>
	<!-- //Bootstrap Core JavaScript -->;./''