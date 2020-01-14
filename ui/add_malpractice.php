<?php
session_start();
include('../assets/functions.php');
$userID=$_SESSION['hierachy'];

	$studID = '';
    $deptID = '';
    $courseID = '';
    $lectID = '';
    $offence = '';
    $wit_name = '';
    $wit_phone = '';
    $evidence_name = '';
    $venue = '';
    $mal_date = '';
    $mal_session = '';
    $btn = '';

    if(isset($_GET['id']) && strlen($_GET['id']) >= 1 && $_SERVER["REQUEST_METHOD"] == "GET"){
        $id = ($_GET['id']);

       global $con;
	$v = $con;
        $q = 'SELECT tbl_malpractice.*, tbl_session.*, tbl_student.*, tbl_department.*, tbl_lecturer.* FROM tbl_malpractice INNER JOIN tbl_session ON tbl_malpractice.mal_session=tbl_session.session_ID INNER JOIN tbl_department ON tbl_malpractice.deptID=tbl_department.dept_ID INNER JOIN tbl_student ON tbl_malpractice.studID=tbl_student.reg_no INNER JOIN tbl_lecturer ON tbl_malpractice.lectID=tbl_lecturer.lect_ID WHERE mal_ID="'.$id.'"';
        $q2 = mysqli_query($v, $q);
        $row = mysqli_fetch_assoc($q2);

        $malID = $row['mal_ID'];
        $studID = $row['studID'];
        $deptID = $row['deptID'];
        $courseID = $row['courseID'];
        $lectID = $row['lectID'];
        $offence = $row['offence'];
        $wit_name = $row['wit_name'];
        $wit_phone = $row['wit_phone'];
        $evidence_name = $row['evidence_name'];
        $venue = $row['venue'];
        $mal_date = $row['mal_date'];
        $mal_session = $row['mal_session'];

        $btn = 'edit';

    }elseif(isset($_POST['btnAdd']) && $_SERVER["REQUEST_METHOD"] == "POST"){

       
        $e = 0;

        $studID = ($_POST['studID']);
        $deptID = ($_POST['deptID']);
        $courseID = ($_POST['courseID']);
        $lectID = ($_POST['lectID']);
        $offence = ($_POST['offence']);
        $wit_name = ($_POST['wit_name']);
        $wit_phone = ($_POST['wit_phone']);
        $evidence_name = ($_POST['evidence_name']);
        $venue = $_POST['venue'];
        $mal_date = ($_POST['mal_date']);
        $mal_session = ($_POST['mal_session']);


        foreach($_POST as $x=>$val){
            if(empty($val)) {
              ECHO  $e++;
            }
        }

        if($e > 0){
            $_SESSION['add_err'] = "Please fill in all fields";
        }else {
            $x = insertRecord($studID, $deptID, $courseID, $lectID, $offence, $wit_name, $wit_phone, $evidence_name, $venue, $mal_date, $mal_session);
            if($x == 0){
                $studID = '';
			    $deptID = '';
			    $courseID = '';
			    $lectID = '';
			    $offence = '';
			    $wit_name = '';
			    $wit_phone = '';
			    $evidence_name = '';
			    $venue = '';
			    $mal_date = '';
			    $mal_session = '';
                $btn = '';
                $_SESSION['add_err'] = "Linkage Successfully Added";
            }else{
                $_SESSION['add_err'] = "Error: Unable to add Linkage";
            }
        }
    }elseif(isset($_POST['btnEdit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $e = 0;
        $studID = ($_POST['studID']);
        $mID = ($_POST['mID']);
        $deptID = ($_POST['deptID']);
        $courseID = ($_POST['courseID']);
        $lectID = ($_POST['lectID']);
        $offence = ($_POST['offence']);
        $wit_name = ($_POST['wit_name']);
        $wit_phone = ($_POST['wit_phone']);
        $evidence_name = ($_POST['evidence_name']);
        $venue = $_POST['venue'];
        $mal_date = ($_POST['mal_date']);
        $mal_session = ($_POST['mal_session']);


        $btn = 'edit';

        foreach($_POST as $x=>$val){
            if(empty($val)) {
                $e++;
            }
        }

        if($e > 0){
            $_SESSION['add_err'] = "Please fill in all fields";
        }else {
            $x = updateRecord($mID, $studID, $deptID, $courseID, $lectID, $offence, $wit_name, $wit_phone, $evidence_name, $venue, $mal_date, $mal_session);
            if($x == 0){
                 $_SESSION['add_err'] = "Record Update Successfull!";
            }else{
                $_SESSION['add_err'] = "Error: Unable to update record";
            }
        }
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
	        <script type="text/javascript" src="ajaxfile.js"></script>

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
							<form action="" method="post" class="p-3">
							<input type="hidden" name="mID" value="<?php echo $malID; ?>">
							<div class="form-group">
								<select name="deptID" id="deptID" class="form-control" onchange="selectproduct1(this.value)">
									<?php echo loadDeptIntoCombo($deptID); ?>
								</select>
							</div>
							<div class="form-group">
								<select name="studID" id="studID" class="form-control">
									<option value='-1'>--Select Student--</option>
								</select>
							</div>
							<div class="form-group">
								<select name="lectID" class="form-control">
									<?php echo loadLecturerIntoCombo($lectID); ?>
								</select>
							</div><div class="form-group">
								<select  id="deptID" class="form-control" onchange="selectproduct2(this.value)">
									<?php echo loadDeptCIntoCombo($deptID); ?>
								</select>
							</div>
							<div class="form-group">
								<select name="courseID" id="courseID" class="form-control">
									<option value='-1'>--Select Course--</option>
								</select>
							</div>
							<div class="form-group">
								<select name="offence" id="offence" class="form-control">
									<?php echo loadOffenceIntoCombo($offence); ?>
								</select>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Witness Name" name="wit_name" value="<?php echo $wit_name; ?>" id="password" required="">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Witness Phone" name="wit_phone" value="<?php echo $wit_phone; ?>" id="password" required="">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Type of Evidence" name="evidence_name" value="<?php echo $evidence_name; ?>" id="password" required="">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Venue of Exams" name="venue" value="<?php echo $venue; ?>" id="password" required="">
							</div>
							<div class="form-group">
								<input type="date" class="form-control" placeholder="Enter Date of Exams" name="mal_date" value="<?php echo $mal_date; ?>" id="password" required="">
							</div>
							<div class="form-group">
								<select name="mal_session" class="form-control">
									<?php echo loadSessionIntoCombo($mal_session); ?>
								</select>
							</div>
							<div class="btn btn-success">
								<?php
                                    if($btn == 'edit'){
                                        echo '<input type="submit" name="btnEdit" class="form-control btn btn-success" value="Update">';
                                    }else{
                                        echo '<input type="submit" name="btnAdd" class=" btn btn-success" value="Add Record">';
                                    }
                                ?>
							</div>
							<div class="row sub-w3l my-3">
								
							</div>
							</form>
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