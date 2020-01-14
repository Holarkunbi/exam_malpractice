<?php
session_start();
include('../assets/functions.php');
$userID=$_SESSION['hierachy'];

if (isset($_GET['id']) && strlen($_GET['id']) >= 1 && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    global $con;
	 $v = $con;
        $q = "SELECT tbl_malpractice.*, tbl_session.*, tbl_student.*, tbl_department.*, tbl_offence.*, tbl_lecturer.*, tbl_course.* FROM tbl_malpractice INNER JOIN tbl_session ON tbl_malpractice.mal_session=tbl_session.session_ID INNER JOIN tbl_department ON tbl_malpractice.deptID=tbl_department.dept_ID INNER JOIN tbl_student ON tbl_malpractice.studID=tbl_student.reg_no INNER JOIN tbl_offence ON tbl_malpractice.offence=tbl_offence.offence_ID INNER JOIN tbl_lecturer ON tbl_malpractice.lectID=tbl_lecturer.lect_ID INNER JOIN tbl_course ON tbl_malpractice.courseID=tbl_course.course_ID where tbl_malpractice.mal_ID='$id'";
        $q2 = mysqli_query($v, $q) or die(mysqli_error($v));
        $r = '';
        $sn=0;
        //if(mysqli_num_rows($q2) > 0){
        $row = mysqli_fetch_assoc($q2);
        $studID = $row['studID'];
        $studName = $row['fname'] . ' ' . $row['lname'];
        $deptName = $row['dept_name'];
        $courseID = $row['courseID'];
        $courseN = $row['course_name'];
        $lecturer = $row['lect_name'] . ' ' . $row['dept_name'];
        $offence = $row['offence_name'];
        $witName = $row['wit_name'];
        $witPhone = $row['wit_phone'];
        $venue = $row['venue'];
        $date = $row['mal_date'];
        $sessName = $row['session_name'];


}
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
					<table class="table table-bordered">
						<tr>
							<th>Course Code and Name</th>
							<td><?php echo $courseID.': '. $courseN; ?></td>
						</tr>
						<tr>
							<th>Offence</th>
							<td><?php echo $offence; ?></td>
						</tr>
						<tr>
							<th>Venue</th>
							<td><?php echo $venue; ?></td>
						</tr>
						<tr>
							<th>Date</th>
							<td><?php echo $date; ?></td>
						</tr>
						<tr>
							<th>Session</th>
							<td><?php echo $sessName; ?></td>
						</tr>
						<tr>
							<th class="text-center" colspan="2">Student's Details</th>
						</tr>
						<tr>
							<th>Student Name</th>
							<td><?php echo $studName; ?></td>
						</tr>
						<tr>
							<th>Reg. Number</th>
							<td><?php echo $studID; ?></td>
						</tr>
						<tr>
							<th>Department</th>
							<td><?php echo $deptName; ?></td>
						</tr>
						<tr>
							<th>Lecturer Name and Department</th>
							<td><?php echo $lecturer; ?></td>
						</tr>
						<tr>
							<th colspan="2" class="text-center">Witness Details</th>
						</tr>
						<tr>
							<th>Witness Name</th>
							<td><?php echo $witName; ?></td>
						</tr>
						<tr>
							<th>Witness Contact</th>
							<td><?php echo $witPhone; ?></td>
						</tr>
					</table>
					
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