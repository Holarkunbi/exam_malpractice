<?php
if (!isset($_SESSION)){
	@session_start();
}
$con = mysqli_connect('localhost', 'root', '', 'db_exam_malpractice');

if ($con) {
}else{
	die('No Connection Found');
}
/*require_once("db_connect.php");
openConnection();*/

function redirectTo($url) {
    header("location: " . $url);
}

function loadNavigation($userID){
	$x='';
if ($userID==1) {
	$x = '
		
				<ul class="sidebar-menu">
					<li class="treeview">
						<a href="index.php">
							<i class="fas fa-home"></i>
							<span>Home</span>
						</a>
					</li>
					<li class="treeview">
						<a href="dashboard.php">
							<i class="fas fa-list-alt"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="add_malpractice.php">
							<i class="fas fa-plus"></i>
							<span>Add Malpractice</span>
						</a>
					</li>
					<li class="treeview">
						<a href="report.php">
							<i class="fa fa-list"></i>
							<span>Report Generator</span>
						</a>
					</li>
				
	';
}elseif ($userID==2) {
	$x = '
		
				<ul class="sidebar-menu">
					<li class="treeview active">
						<a href="index.html">
							<i class="fas fa-home"></i>
							<span>Home</span>
						</a>
					</li>
					<li class="treeview">
						<a href="about.html">
							<i class="fas fa-info"></i>
							<span>About</span>
						</a>
					</li>
					<li class="treeview">
						<a href="services.html">
							<i class="fab fa-servicestack"></i>
							<span>Services</span>
						</a>
					</li>
				
	';
} echo $x;
}
function loginValidate($username,$password){
	$sql = mysqli_query("SELECT * FROM tbl_login WHERE username='$username' && password='$password'") or die(mysqli_error());
	$row=mysqli_fetch_array($sql);
	$uid = $u_ID;
	if (mysqli_num_rows($sql))
		return 0;
	else return 1;
}

function is_logged_in(){
	if((isset($_SESSION['cus_user_id']) && (strlen($_SESSION['cus_user_id']) > 0)) || 
		(isset($_SESSION['ad_user_id']) && (strlen($_SESSION['ad_user_id']) > 0)) ||
		(isset($_SESSION['st_username']) && (strlen($_SESSION['st_username']) > 0)) ){
		//redirectTo('login.php');
	}else{
		redirectTo('./index.php');
	}
}

function getAllMalpractice() {
	 global $con;
	 $v = $con;
        $q = "SELECT tbl_malpractice.*, tbl_session.*, tbl_student.*, tbl_department.* FROM tbl_malpractice INNER JOIN tbl_session ON tbl_malpractice.mal_session=tbl_session.session_ID INNER JOIN tbl_department ON tbl_malpractice.deptID=tbl_department.dept_ID INNER JOIN tbl_student ON tbl_malpractice.studID=tbl_student.reg_no";
        $q2 = mysqli_query($v, $q);
        $r = '';
        $sn=0;
        if(mysqli_num_rows($q2) > 0){
            while($row = mysqli_fetch_assoc($q2)){
            	$sn++;
                $r .= '
                    <tr class="odd gradeX">
                    	<td> '.$sn.' </td>
                        <td> '.$row['lname'].' '.$row['fname'].' </td>
                        <td> '.$row['dept_name'].'  </td>
                        <td> '.$row['session_name'].'  </td>
                    ';
                $r.= '
                    <td><a href="add_malpractice.php?id='.$row['mal_ID'].'" class="btn btn-success" title="Edit Details"><i class="fa fa-edit"></i></a>
                            <a href="view_malpractice.php?id='.$row['mal_ID'].'" class="btn btn-info" title="View Details"><i class="fa fa-eye"></i></a></td></tr>';
            }
        }else{
            $r .= '
                  <tr class="odd gradeX">
                    <td colspan="8">
                        <div class="alert alert-danger text-center"> No Records Found!</div>
                    </td>
                </tr>';
        } return $r;
}

function getAllMalpractices($search) {
	 global $con;
	 $v = $con;
        $q = "SELECT tbl_malpractice.*, tbl_session.*, tbl_student.*, tbl_department.*, tbl_offence.*, tbl_lecturer.* FROM tbl_malpractice INNER JOIN tbl_session ON tbl_malpractice.mal_session=tbl_session.session_ID INNER JOIN tbl_department ON tbl_malpractice.deptID=tbl_department.dept_ID INNER JOIN tbl_student ON tbl_malpractice.studID=tbl_student.reg_no INNER JOIN tbl_offence ON tbl_malpractice.offence=tbl_offence.offence_ID INNER JOIN tbl_lecturer ON tbl_malpractice.lectID=tbl_lecturer.lect_ID where tbl_malpractice.mal_session='$search'";
        $q2 = mysqli_query($v, $q) or die(mysqli_error($v));
        $r = '';
        $r .='
        	<table class="table table-bordered">
							<thead>
								<th>S/N</th>
								<th>Offence</th>
								<th>Students</th>
								<th>Department</th>
								<th>Lecturer Name/ Dept.</th>
								<th>Action</th>
							</thead>
							
								
							
        ';
        $sn=0;
        if(mysqli_num_rows($q2) > 0){
            while($row = mysqli_fetch_assoc($q2)){
            	$sn++;
                $r .= '
                <tbody>
                    <tr class="odd gradeX">
                    	<td> '.$sn.' </td>
                    	<td> '.$row['offence_name'].'  </td>
                        <td> '.$row['lname'].' '.$row['fname'].' </td>
                        <td> '.$row['dept_name'].'  </td>
                        <td> '.$row['lect_name'].' '.$row['dept_name'].' </td>
                    ';
                $r.= '
                    <td><a href="add_malpractice.php?id='.$row['mal_ID'].'" class="btn btn-success" title="Edit Details"><i class="fa fa-edit"></i></a>
                            <a href="view_malpractice.php?id='.$row['mal_ID'].'" class="btn btn-info" title="View Details"><i class="fa fa-eye"></i></a></td></tr>';
            }
        }else{
            $r .= '
                  <tr class="odd gradeX">
                    <td colspan="5">
                        <div class="alert alert-danger text-center"> No Records Found!</div>
                    </td>
                </tr></tbody></table>';
        } return $r;
}

function clean($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($str);
}

function insertRecord($studID, $deptID, $courseID, $lectID, $offence, $wit_name, $wit_phone, $evidence_name, $venue, $mal_date, $mal_session) {
    global $con;
    $v = $con;
    $q = 'INSERT INTO tbl_malpractice (studID, deptID, courseID, lectID, offence, wit_name, wit_phone, evidence_name, venue, mal_date, mal_session)
              VALUES("' . $studID . '", "' . $deptID . '", "' . $courseID . '", "' . $lectID . '", "' . $offence . '", "' . $wit_name . '", "' . $wit_phone . '", "' . $evidence_name . '", "' . $venue . '", "' . $mal_date . '", "' . $mal_session . '")';
    $q2 = mysqli_query($v, $q);
    if ($q2) {
        return 0;
        /*$sql3 = "SELECT LAST_INSERT_ID() as linkage_id FROM tbl_insert_linkage";
        $q3 = mysqlii_query($v, $sql3);
        $fetch = mysqlii_fetch_assoc($q3);
        $linkage_id = $fetch['linkage_id'];
//insert into objectives table

        foreach ($objective as $obj) {
            if (!empty($obj)) {
                $sql4 = "INSERT INTO tbl_objective VALUES('','" . $linkage_id . "','" . $obj . "')";
                $q4 = mysqlii_query($v, $sql4);
            }
        }
        foreach ($org as $orgi) {
            if (!empty($orgi)) {
                $sql5 = "INSERT INTO tbl_insert_org VALUES('','" . $random . "','" . $orgi . "')";
                $q6 = mysqlii_query($v, $sql5) or die(mysqlii_error($v));
            }
        }
        echo "0";*/
       //header("Location: insert_Beneficiaries.php");
    } else {
        return 1;
    }
}
    function updateRecord($mID, $studID, $deptID, $courseID, $lectID, $offence, $wit_name, $wit_phone, $evidence_name, $venue, $mal_date, $mal_session){
    global $con;
    $v = $con;
    $q = 'UPDATE tbl_malpractice
                  SET
                  studID="' . $studID . '",
                 
                  deptID="' . $deptID . '",
                  courseID="' . $courseID . '",
                  lectID="' . $lectID . '",
                      offence="' . $offence . '",
                  wit_name="' . $wit_name . '",
                  wit_phone="' . $wit_phone . '",
                  evidence_name="' . $evidence_name . '",
                  venue="' . $venue . '",
                  mal_date="' . $mal_date . '",
                  mal_session="' . $mal_session . '"
                  WHERE mal_ID = "' . $mID . '"';
    $q2 = mysqli_query($v, $q) or die(mysqli_error());
    if ($q2) {
        return 0;
    } else {
        return 1;
    }
  }
function welcomeCustomer($id){
	$q = "SELECT * FROM tbl_student WHERE rowid='".$id."'";
	$q2 = mysqli_query($q);
	$exist = mysqli_num_rows($q2);
	if($exist == 1){
		$row = mysqli_fetch_assoc($q2);
		return $row['first_name'].' '.$row['other_names'];
	}else{
		return '0';
	}
}

function is_id_valid($id){
	$q = "SELECT * FROM tbl_route WHERE rowid='".$id."'";
	$q2 = mysqli_query($q);
	if(mysqli_num_rows($q2) === 1){
		return '1';
	}
	return '0';
}

function embed_menu_bar($user_group, $adminID) {
	$result = mysqli_query("SELECT * FROM tbl_admin WHERE rowid='$adminID'");
	 $row = mysqli_fetch_array($result);
	$lvl = $row['level'];
	
	//manage reservations and print ticket url parameters 
	$w = 'reserve';
	$q = 'cancel';
	$t = 'ticket';
	$l = 'trans';
	$w1 = base64_encode(urlencode($w));	
	$q1 = base64_encode(urlencode($q));
	$t1 = base64_encode(urlencode($t));
	$l1 = base64_encode(urlencode($l));
	
	//manage staff url parameters
	$eds = 'editstaff';
	$ads = 'addstaff';
	$ds = 'deletestaff';
	$vs = 'viewstaff';
	$eds1 = base64_encode(urlencode($eds));
	$ads1 = base64_encode(urlencode($ads));
	$ds1 = base64_encode(urlencode($ds));
	$vs1 = base64_encode(urlencode($vs));
	
	//manage bus url parameters
	$adb = 'addroom';
	$db = 'deleteroom';
	$vb = 'viewroom';
	$ubr = 'unbookedroom';
	$adb1 = base64_encode(urlencode($adb));
	$db1 = base64_encode(urlencode($db));
	$vb1 = base64_encode(urlencode($vb));
	$ubr1 = base64_encode(urlencode($ubr));
	
	//manage route url parameters
	$adr = 'addroute';
	$dr = 'deleteroute';
	$adbr = 'addbusroute';
	$dbr = 'deletebusroute';
	$adr1 = base64_encode(urlencode($adr));
	$dr1 = base64_encode(urlencode($dr));
	$adbr1 = base64_encode(urlencode($adbr));
	$dbr1 = base64_encode(urlencode($dbr));
	
	//manage customers url parameters
	$cbr = 'cusbyroom';
	$cbt = 'cusbytime';
	$vbr = 'bookedroom';
	$cbr1 = base64_encode(urlencode($cbr));
	$cbt1 = base64_encode(urlencode($cbt));
	$vbr1 = base64_encode(urlencode($vbr));
	
	$r = "<div id='cssmenu' style='background: green;'>
			<ul>";
			/*<li class='has-sub'><a href=''><span>Manage Reservation</span></a>
						  <ul>
							 <li><a href='manageroute.php?".$adr1."'><span>Add New Route</span></a></li>		
 							 <li><a href='manageroute.php?".$dr1."'><span>Delete Route</span></a></li>
							 <li><a href='manageroute.php?".$adbr1."'><span>Add Bus to Route</span></a></li>
							 <li class='last'><a href='manageroute.php?".$dbr1."'><span>Delete Bus from Route</span></a></li>
						  </ul>
					   </li>*/
			if (strtolower($user_group) == 'admin') {
					$r .="<li><a href='./admin.php'><span>Home</span></a></li>";
				if ($lvl==1) {
					$r .="
                        <li class='has-sub'><a href=''><span>Manage Rooms</span></a>
						  <ul>
							 <!--li><a href='manageroom.php?".$adb1."'><span>Add New Room</span></a></li-->		
							 <li><a href='manageroom.php?".$vb1."'><span>Reserved Rooms</span></a></li>		
							 <!--li><a href='manageroom.php?".$db1."'><span>Change Room Status</span></a></li-->
							 <li class='last'><a href='manageroom.php?".$ubr1."'><span>Available Rooms</span></a></li>
						  </ul>
					   </li>
					   <li class='has-sub'><a href='managecustomers.php?".$vbr1."'><span>Manage Payment</span></a>
					   	   <ul>
							 <li><a href='managecustomers.php?".$vbr1."'><span>View Paid Rooms</span></a></li>		
							 <li class='last'><a href='managecustomers.php?".$cbr1."'><span>View Unpaid Rooms</span></a></li>
						  </ul>
					  </li>";	# code...
				}elseif ($lvl==2) {
					$r .="<li class='has-sub'><a href='managecustomers.php?".$vbr1."'><span>Manage Payment</span></a>
					   	   <ul>
							 <li><a href='managecustomers.php?".$vbr1."'><span>View Paid Rooms</span></a></li>		
							 <li class='last'><a href='managecustomers.php?".$cbr1."'><span>View Unpaid Rooms</span></a></li>
						  </ul>
					  </li>";# code...
				}elseif ($lvl==3) {
					$r .="<li class='has-sub'><a href='managecustomers.php?".$vbr1."'><span>Manage Payment</span></a>
					   	   <ul>
							 <li><a href='managecustomers.php?".$vbr1."'><span>View Paid Rooms</span></a></li>		
						  </ul>
					  </li>";
				}	
				$r .= "<li class='has-sub last'><a href='logout.php'><span>Logout</span></a></li>";
			}  
		$r .= "</ul> </div>";
		echo $r;
}

function fetch_staff(){
	$x = 1;
	$r = "<div id='page'>";
	while($x <= 5){
	$r .= '<div id="main">
		<div class="ct">
			<div id="s_pic">
				<img src="images/5.jpg" width="100%" height="100%"/>
			</div>
			<div id="s_data">
				<table width="100%">
					<tr>
						<td width="30%"> <div class="lbl_staff_title"> Name : </div> </td>
						<td> <div class="lbl_staff_data"> Jerry Emmanuel </div> </td>
					</tr>
					<tr>
						<td width="25%"> <div class="lbl_staff_title"> Department : </div> </td>
						<td> <div class="lbl_staff_data"> Management Information System </div> </td>
					</tr>
				</table>
			</div>
		</div>		
	</div>';
	$x++;
	}
	$r .= '</div>';
	return $r;
}
function loadDeptIntoCombo($param_cat=''){
	global $con;
	$v = $con;
        $r= '';

        $q = "SELECT * FROM tbl_department ORDER BY dept_name";
        $query = mysqli_query($v, $q) or die(mysqli_error($v));
        $total_rows_found = mysqli_num_rows($query);
        $cat_found=false;
        if ($total_rows_found > 0) {
            $r .= "<option value = '-1'>-- Select Department --</option>";
            while ($row = mysqli_fetch_assoc($query)){
                if($row['dept_ID'] == $param_cat){
                    $r .= "<option value='" . $row['dept_ID'] . "' selected='selected'>" . $row['dept_name'] . "</option>";
                    $cat_found = true;
                }else{
                    $r.= "<option value='" . $row['dept_ID'] . "'>" . $row['dept_name'] . "</option>";
                }
            }
        }else{
            $r = "<option value = '-1'>No data in Department table</option>";
        }//end if ($total_rows_found == 1)

        return $r;
    }

function loadDeptCIntoCombo($param_cat=''){
	global $con;
	$v = $con;
        $r= '';

        $q = "SELECT * FROM tbl_department ORDER BY dept_name";
        $query = mysqli_query($v, $q) or die(mysqli_error($v));
        $total_rows_found = mysqli_num_rows($query);
        $cat_found=false;
        if ($total_rows_found > 0) {
            $r .= "<option value = '-1'>-- Select Courses Department --</option>";
            while ($row = mysqli_fetch_assoc($query)){
                if($row['dept_ID'] == $param_cat){
                    $r .= "<option value='" . $row['dept_ID'] . "' selected='selected'>" . $row['dept_name'] . "</option>";
                    $cat_found = true;
                }else{
                    $r.= "<option value='" . $row['dept_ID'] . "'>" . $row['dept_name'] . "</option>";
                }
            }
        }else{
            $r = "<option value = '-1'>No data in Department table</option>";
        }//end if ($total_rows_found == 1)

        return $r;
    }

function loadLecturerIntoCombo($param_cat=''){
	global $con;
	$v = $con;
        $r= '';

        $q = "SELECT * FROM tbl_lecturer INNER JOIN tbl_department ON tbl_lecturer.lect_dept=tbl_department.dept_ID  ORDER BY dept_name";
        $query = mysqli_query($v, $q) or die(mysqli_error($v));
        $total_rows_found = mysqli_num_rows($query);
        $cat_found=false;
        if ($total_rows_found > 0) {
            $r .= "<option value = '-1'>-- Select Lecturer --</option>";
            while ($row = mysqli_fetch_assoc($query)){
                if($row['lect_ID'] == $param_cat){
                    $r .= "<option value='" . $row['lect_ID'] . "' selected='selected'>" . $row['lect_name'] . "" . $row['dept_name'] . "</option>";
                    $cat_found = true;
                }else{
                    $r.= "<option value='" . $row['lect_ID'] . "'>" . $row['lect_name'] . " (" . $row['dept_name'] . ")</option>";
                }
            }
        }else{
            $r = "<option value = '-1'>No data in Lecturer table</option>";
        }//end if ($total_rows_found == 1)

        return $r;
    }

function loadOffenceIntoCombo($param_cat=''){
	global $con;
	$v = $con;
        $r= '';

        $q = "SELECT * FROM tbl_offence";
        $query = mysqli_query($v, $q) or die(mysqli_error($v));
        $total_rows_found = mysqli_num_rows($query);
        $cat_found=false;
        if ($total_rows_found > 0) {
            $r .= "<option value = '-1'>-- Select Offence --</option>";
            while ($row = mysqli_fetch_assoc($query)){
                if($row['offence_ID'] == $param_cat){
                    $r .= "<option value='" . $row['offence_ID'] . "' selected='selected'>" . $row['offence_name'] . "" . $row['dept_name'] . "</option>";
                    $cat_found = true;
                }else{
                    $r.= "<option value='" . $row['offence_ID'] . "'>" . $row['offence_name'] . "</option>";
                }
            }
        }else{
            $r = "<option value = '-1'>No data in Offence table</option>";
        }//end if ($total_rows_found == 1)

        return $r;
    }

 function loadSessionIntoCombo($param_cat=''){
 	global $con;
	$v = $con;
        $r= '';

        $q = "SELECT * FROM tbl_session";
        $query = mysqli_query($v, $q) or die(mysqli_error($v));
        $total_rows_found = mysqli_num_rows($query);
        $cat_found=false;
        if ($total_rows_found > 0) {
            $r .= "<option value = '-1'>-- Select Session --</option>";
            while ($row = mysqli_fetch_assoc($query)){
                if($row['session_ID'] == $param_cat){
                    $r .= "<option value='" . $row['session_ID'] . "' selected='selected'>" . $row['session_name'] . "" . $row['dept_name'] . "</option>";
                    $cat_found = true;
                }else{
                    $r.= "<option value='" . $row['session_ID'] . "'>" . $row['session_name'] . "</option>";
                }
            }
        }else{
            $r = "<option value = '-1'>No data in Session table</option>";
        }//end if ($total_rows_found == 1)

        return $r;
    }


function reservation($userID){
	$r = '';
	$roomid = '';
	if(isset($_POST['btnReserve'])){
                    
            $room_id = clean($_POST['roomNum']);
            $block_num = clean($_POST['blockNum']);
            //$accName = clean($_POST['accName']);
            //$accNum = clean($_POST['accNum']);
            $id = gettranscode('AT');
            $_SESSION['r_ticket'] = $id;
            //echo $date1." ". $date2; exit;
            //echo $date1." ". $date2; exit; && notempty($date2) && notempty($room_id) && notempty($accName) && notempty($accNum)
            if($room_id > 0){
                $res1 = 'INSERT INTO tbl_booking 
                        (room_id, blockID, customer_id, paid, ticket_id) 
                        VALUES("'.$room_id.'", "'.$block_num.'", "'.$_SESSION['cus_user_id'].'", "0", "'.$id.'")';
                $res = mysqli_query($res1) or die(mysqli_error());
                if($res){		
                    $r .= get_user_valid_ticket($_SESSION['r_ticket']);
                    mysqli_query("UPDATE tbl_room SET reserved='YES' WHERE rowid='$room_id'");
                }else{
                    $_SESSION['RESERVATION_ERR_MSG'] = '<span style="color:red">Reservation Unsuccessful</span>';
                    redirectTo('./customers.php?cmVzZXJ2ZQ==');
                }
            }else{
                $_SESSION['RESERVATION_ERR_MSG'] = 'Please fill in all fields';
                redirectTo('./customers.php?cmVzZXJ2ZQ==');
            }
	//if user is to make reservation
	}else{
            $r .= '<div align="center"><h2> Proceed with Reservation </h2></div> <br/>';
                if(isset($_SESSION['RESERVATION_ERR_MSG']) && strlen($_SESSION['RESERVATION_ERR_MSG'])>0){
                    $r .= "<p align='center' class='err_msg'>". $_SESSION['RESERVATION_ERR_MSG']. "</p>";
                    $_SESSION['RESERVATION_ERR_MSG'] = '';
                }

             $que = mysqli_query("SELECT * FROM tbl_booking WHERE customer_id='$userID' AND paid=1") or die(mysqli_error());
             if (mysqli_num_rows($que)>0) {
             	$r .=	'<div class="inner" style="width:70%; margin-left:15%; font-size:15px;">
             	<br>
             			<center><h3>You have already made a reservation! <br> Click <a href="customers.php?Ym9va2Vk">Here</a> to view it.</h3></center>
             			';
             }else{
             $q = "SELECT * FROM tbl_student where rowid ='$userID'";
	        $query = mysqli_query($q) or die(mysqli_error());
	        $row = mysqli_fetch_array($query);
	        $gender = $row['gender'];

	        if ($gender=="male") {
	        	$r .=	'<div class="inner" style="width:70%; margin-left:15%; font-size:15px;">
                    <form action="" method="post" id="form">
                        <fieldset style=" padding:10px 10px 10px 40px;">
                            <div class="field"> Hostel: &nbsp;
                                <select class="select3" name="roomType" id="roomType" style="width:75.5%">'.
                                     loadMRoomCatIntoCombo().'
                             </select>
                            </div>
                            <br/>
                            <div class="field"> Block Number: &nbsp;
                                <select class="select3" name="blockNum" id="blockNum" style="width:60.5%"> </select>
                            </div>
                            <br/>
                            <div class="field"> Room Number: &nbsp;
                                <select class="select3" name="roomNum" id="roomNum" style="width:60.5%"> </select>
                            </div>
                            <br/>
                            <div class="button"> <input type="submit" value="Reserve" name="btnReserve" /> </div>
                        </fieldset>
                    </form>
                  </div> <br/><br/>';
	        }
	        elseif ($gender=="female") {
	        	$r .=	'<div class="inner" style="width:70%; margin-left:15%; font-size:15px;">
                    <form action="" method="post" id="form">
                        <fieldset style=" padding:10px 10px 10px 40px;">
                            <div class="field"> Hostel: &nbsp;
                                <select class="select3" name="roomType" id="roomType" style="width:75.5%">'.
                                     loadFRoomCatIntoCombo($roomid).'
                             </select>
                            </div>
                            <div class="field"> Block Number: &nbsp;
                                <select class="select3" name="blockNum" id="blockNum" style="width:60.5%"> </select>
                            </div>
                            <div class="field"> Room Number: &nbsp;
                                <select class="select3" name="roomNum" id="roomNum" style="width:60.5%"> </select>
                            </div>
                            
                            <br/>
                            <div class="button"> <input type="submit" value="Reserve" name="btnReserve" /> </div>
                        </fieldset>
                    </form>
                  </div> <br/><br/>';
	        }
		}
	}
	echo $r;
}


function checkTicketID($id){
	$q = "SELECT * FROM tbl_booking WHERE ticket_id='".$id."'";
	$q2 = mysqli_query($q);
	$exist = mysqli_num_rows($q2);
	if($exist == 1){
		return '1';
	}else{
		return '0';
	}
}

function print_ticket(){
	if(isset($_POST['btnCancelReservation'])){
		$id = clean($_POST['txtTickedID']);
		
		if(checkTicketID($id) == '1'){
			$del1 = 'SELECT * FROM tbl_booking WHERE ticket_id="'.$id.'"';
			$del = mysqli_query($del1);
			if($del){
				echo get_user_valid_ticket($id); exit;
			}else{
				$_SESSION['CRESERVATION_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
			}
		}else{
			$_SESSION['CRESERVATION_ERR_MSG'] = '<h3 style="color:red">Invalid Ticket ID</h3>';
		}
	}
	$r = '<div align="center"><h3> Print your Ticket </h3></div> <br/>';
		if(isset($_SESSION['CRESERVATION_ERR_MSG']) && strlen($_SESSION['CRESERVATION_ERR_MSG'])>0){
			$r .= "<p align='center' class='err_msg'>". $_SESSION['CRESERVATION_ERR_MSG']. "</p>";
			$_SESSION['CRESERVATION_ERR_MSG'] = '';
		}
	$r .=		'<form method="POST" action="" id="form">
				<table id="tbl_reservation2" align="center">
				<tr>
					<td> <h3>Enter your ticked ID</h3> </td>
					<td> <input type="text" name="txtTickedID" required/> </td>
				</tr>
				<tr>
					<td colspan="2"> 
						<input type="submit" id="btnCancelReservation" name="btnCancelReservation" value="Submit"/> 
					<br/>
					</td>
				</tr>
				</table>
			</form> <br/><br/>';
	echo $r;
}

function addstaff(){
	if(isset($_POST['btnAddUser'])){
		$fname = clean($_POST['txtFname']);
		$oname = clean($_POST['txtOname']);
		$email = clean($_POST['txtEmail']);
		$num = clean($_POST['txtNum']);
		$staffId = clean($_POST['txtStaffId']);
		$uname = clean($_POST['txtUserName']);
		$pwd = clean($_POST['txtPassword']);
		$role = clean($_POST['role']);
		
		$add1 = 'INSERT INTO tbl_staff (staff_id, first_name, other_names, email_address, mobile_number, username, password, role) 
				VALUES("'.$staffId.'", "'.$fname.'", "'.$oname.'", "'.$email.'", "'.$num.'", "'.$uname.'", "'.$pwd.'", "'.$role.'")';
		$add = mysqli_query($add1);
		if($add){
			$_SESSION['ADD_USER_ERR_MSG'] = '<h3 style="color:green">Staff Successfully Added</h3>';
		}else{
			$_SESSION['ADD_USER_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
		}
	}
	$r = '<table id="tbl_content">
			<tr>
				<td width="75%">';
						if(isset($_SESSION['ADD_USER_ERR_MSG']) && strlen($_SESSION['ADD_USER_ERR_MSG'])>0){
							echo "<p align='center' class='err_msg'>". $_SESSION['ADD_USER_ERR_MSG']. "</p>";
							$_SESSION['ADD_USER_ERR_MSG'] = '';
						}
					// sub content -->
			$r .=		'<div class="form_outline_div">
						<h1>Add New Staff</h1>
						<form name="frmAddUser" id="frmAddUser" method="post" action="">
						<table align="center">
							<tr><td>First name:</td><td><input type="text" name="txtFname" id="txtFname" required /></td></tr>
							<tr><td>Other names:</td><td><input type="text" name="txtOname" id="txtOname" required /></td></tr>
							<tr><td>Email address:</td><td><input type="text" name="txtEmail" id="txtEmail" required /></td></tr>
							<tr><td>Mobile number:</td><td><input type="text" name="txtNum" id="txtNum" required /></td></tr>
							<tr><td>Role:</td>
							<td>
								<select name="role">
									<option value="1">admin</option>
									<option value="2">staff</option>
								</select>
							</td></tr>
							<tr><td>Staff ID:</td><td><input type="text" name="txtStaffId" id="txtStaffId" required /></td></tr>
							<tr><td>Username:</td><td><input type="text" name="txtUserName" id="txtUserName" required /></td></tr>
							<tr><td>Password:</td><td><input type="password" name="txtPassword" id="txtPassword" required /></td></tr>							
							<tr><td></td>
							<td style="float:left">
								<input type="submit" name="btnAddUser" id="btnAddUser" value="Add" title="click to add user"/>
								<input type="hidden" name="detr" value="log"/>
							</td></tr>
						</table>
						</form>
					</div>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function createAccount(){
	if(isset($_POST['btnCreateAcct'])){
		$n1 = clean($_POST['txtFname']);
		$n2 = clean($_POST['txtOname']);
		$email = clean($_POST['txtEmail']);
		$num = clean($_POST['txtNum']);
		$gender = clean($_POST['gender']);
		$add = clean($_POST['txtAdd']);
		$uname = clean($_POST['txtUserName']);
		$pwd = clean($_POST['txtPassword']);
		
		$_SESSION['o1'] = $n1;
		$_SESSION['o2'] = $n2;
		$_SESSION['o3'] = $email;
		$_SESSION['o4'] = $num;
		$_SESSION['o6'] = $add;
		$_SESSION['o7'] = $uname;

			if (strlen($n1) < 1 || strlen($n2) < 1 || strlen($email) < 1 || strlen($num) < 1 || strlen($gender) < 1 || strlen($add) < 1 || strlen($uname) < 1 || strlen($pwd) < 1) {
				$_SESSION['ACCT_ERR_MSG'] = "Please fill in all fields";
			}else{
				$add1 = 'INSERT INTO tbl_student (first_name, other_names, gender, email_address, address, mobile_number, username, password, dateTime_registered) 
									VALUES("'.$n1.'", "'.$n2.'", "'.$gender.'", "'.$email.'", "'.$add.'", "'.$num.'", "'.$uname.'", "'.$pwd.'", CURDATE())';
				$add = mysqli_query($add1);
				if($add){
					$_SESSION['o1'] = '';
					$_SESSION['o2'] = '';
					$_SESSION['o3'] = '';
					$_SESSION['o4'] = '';
					$_SESSION['o6'] = '';
					$_SESSION['o7'] = '';
					$_SESSION['ACCT_ERR_MSG'] = '<h3 style="color:green">Account Created. Click <a href="login.php">HERE</a> to login</h3>';
				}else{
					$_SESSION['ACCT_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
					//$_SESSION['ACCT_ERR_MSG'] = mysqli_error();
				}
			
			}
	}
	if(!isset($_SESSION['o1'])){
		$_SESSION['o1'] = '';
		$_SESSION['o2'] = '';
		$_SESSION['o3'] = '';
		$_SESSION['o4'] = '';
		$_SESSION['o6'] = '';
		$_SESSION['o7'] = '';
	}
	$r = '<table id="tbl_content">
			<tr>
				<td width="75%">						
					<div class="form_outline_div" style="width:100% !important; margin-left:20%;"> <br/>
						<h2 align="center">Create your Account</h2>';
						if(isset($_SESSION['ACCT_ERR_MSG']) && strlen($_SESSION['ACCT_ERR_MSG'])>0){
							$r .= "<p align='center' class='err_msg'>". $_SESSION['ACCT_ERR_MSG']. "</p>";
							$_SESSION['ACCT_ERR_MSG'] = '';
						}
			$r .='		<form name="frmAddBus" id="form" method="post" action="" enctype="multipart/form-data">
						<table align="center" style="width:80%; margin:auto;">
							<tr><td>First name:</td><td><input type="text" name="txtFname" id="txtFname" required  value="'.$_SESSION['o1'].'"/></td></tr>
							<tr><td>Other names:</td><td><input type="text" name="txtOname" id="txtOname" required value="'.$_SESSION['o2'].'"/></td></tr>
							<tr><td>Email address:</td><td><input type="text" name="txtEmail" id="txtEmail" required value="'.$_SESSION['o3'].'" /></td></tr>
							<tr><td>Mobile number:</td><td><input type="text" name="txtNum" id="txtNum" required value="'.$_SESSION['o4'].'"/></td></tr>
							<tr><td>Gender:</td>
							<td>
								<select name="gender">
									<option value="">Select your Gender</option>
									<option value="male">male</option>
									<option value="female">female</option>
								</select>
							</td></tr>
							<tr><td>Contact Address:</td><td><input type="text" name="txtAdd" id="txtStaffId" required value="'.$_SESSION['o6'].'"/></td></tr>
							<tr><td>Reg No.:</td><td><input type="text" name="txtUserName" id="txtUserName" required value="'.$_SESSION['o7'].'"/></td></tr>
							<tr><td>Password:</td><td><input type="password" name="txtPassword" id="txtPassword" required /></td></tr>							
							<tr><td></td>
							<td style="float:left">
								<input type="submit" name="btnCreateAcct" id="btnAddUser" value="Create Account" title="click to create account"/>
								<input type="hidden" name="detr" value="log"/>
							</td></tr>
						</table>
						</form>
					</div>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function editstaff(){
	$r = '<table id="tbl_content">
			<tr>
				<td width="75%">';
						if(isset($_SESSION['EDIT_USER_ERR_MSG']) && strlen($_SESSION['EDIT_USER_ERR_MSG'])>0){
							echo "<p align='center' class='err_msg'>". $_SESSION['EDIT_USER_ERR_MSG']. "</p>";
							$_SESSION['EDIT_USER_ERR_MSG'] = '';
						}
					// sub content -->
			$r .=	'<div class="form_outline_div">
						<h1>Edit Staff Profile</h1>
						<form name="frmAddUser" id="form" method="post" action="">
						<table align="center">
							<tr><td>First name:</td><td><input type="text" name="txtFname" id="txtFname" required /></td></tr>
							<tr><td>Other names:</td><td><input type="text" name="txtOname" id="txtOname" required /></td></tr>
							<tr><td>Email address:</td><td><input type="text" name="txtEmail" id="txtEmail" required /></td></tr>
							<tr><td>Mobile number:</td><td><input type="text" name="txtNum" id="txtNum" required /></td></tr>
							<tr><td>Role:</td>
							<td>
								<select name="role">
									<option value=""></option>
									<option value=""></option>
								</select>
							</td></tr>
							<tr><td>Staff ID:</td><td><input type="text" name="txtStaffId" id="txtStaffId" required /></td></tr>
							<tr><td>Username:</td><td><input type="text" name="txtUserName" id="txtUsername" required /></td></tr>
							<tr><td>Password:</td><td><input type="password" name="txtPassword" id="txtPassword" required /></td></tr>							
							<tr><td></td>
							<td style="float:left">
								<input type="submit" name="btnAddUser" id="btnAddUser" value="Add" title="click to add user"/>
								<input type="hidden" name="detr" value="log"/>
							</td></tr>
						</table>
						</form>
					</div>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function deletestaff(){
		if(isset($_POST['btnDeleteStaff'])){
			$id = clean($_POST['txtStaffID']);
			
			$del1 = 'DELETE FROM tbl_staff WHERE staff_id="'.$id.'"';
			$del = mysqli_query($del1);
			if($del){
				$_SESSION['DEL_USER_ERR_MSG'] = '<h3 style="color:green">Staff Successfully Deleted</h3>';
			}else{
				$_SESSION['DEL_USER_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
			}
		}
		$r = '<table id="tbl_content" >
			<tr>
				<td width="75%" id="tbl_del_staff">';
					if(isset($_SESSION['DEL_USER_ERR_MSG']) && strlen($_SESSION['DEL_USER_ERR_MSG'])>0){
						echo "<p align='center' class='err_msg'>". $_SESSION['DEL_USER_ERR_MSG']. "</p>";
						$_SESSION['DEL_USER_ERR_MSG'] = '';
					}
		$r .= 	'<!-- sub content -->
					<div align="center"><h1> Delete Staff Data </h1></div> <br/>
					<form method="POST" action="" id="form">
						<table id="tbl_reservation2" align="center">
						<tr>
							<td> <h3>Enter Staff ID</h3> </td>
							<td> <input type="text" name="txtStaffID" required/> </td>
						</tr>
						<tr>
							<td colspan="2"> 
								<input type="submit" id="btnDeleteStaff" name="btnDeleteStaff" value="Submit"/> 
							<br/>
							</td>
						</tr>
						</table>
					</form>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function addroom(){
	if(isset($_POST['btnAddRoom'])){
		$cat = clean($_POST['txtCategory']);
		$price = clean($_POST['txtPrice']);
		//$capacity = clean($_POST['txtCapacity']);

			if (!isset($cat) || !isset($price)) {
				$_SESSION['ADD_ROOM_ERR_MSG'] = "Please fill in all fields";
			}else{
				$add1 = 'INSERT INTO tbl_room (category_id, price, booked) 
									VALUES("'.$cat.'", "'.$price.'", "unbooked")';
				$add = mysqli_query($add1);
				if($add){
					$_SESSION['ADD_ROOM_ERR_MSG'] = '<h3 style="color:green">Room Successfully Added</h3>';
				}else{
					$_SESSION['ADD_ROOM_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
				}
			
			}
	}
	$r = '<table id="tbl_content">
			<tr>
				<td width="75%">						
					<div class="form_outline_div"> <br/>
						<h2 align="center">Add New Room</h2>';
						if(isset($_SESSION['ADD_ROOM_ERR_MSG']) && strlen($_SESSION['ADD_ROOM_ERR_MSG'])>0){
							$r .= "<p align='center' class='err_msg'>". $_SESSION['ADD_ROOM_ERR_MSG']. "</p>";
							$_SESSION['ADD_ROOM_ERR_MSG'] = '';
						}
			$r .='		<form name="frmAddBus" id="form" method="post" action="" enctype="multipart/form-data">
						<table align="center" style="width:80%; margin:auto;">
							<tr><td>House Category:</td><td><select name="txtCategory">'.load_roomCategory_into_combo().'</select></td></tr>
							<tr><td>Room Price:</td><td><input type="text" name="txtPrice" id="txtPrice" required /></td></tr>
							<tr><td></td>
							<td style="float:left">
								<br/>
								<input type="submit" name="btnAddRoom" id="btnAddRoom" value="Add" title="click to add room"/>
								<input type="hidden" name="detr" value="addroom"/>
								<br/><br/>
							</td></tr>
						</table>
						</form>
					</div>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function updatePayment($ticket){
	$del1 = 'UPDATE tbl_booking SET paid=1 WHERE ticket_id="'.$ticket.'"';
			$del = mysqli_query($del1);
			if($del){
				echo 0;
			}else{
				echo 1;
			}
}

function modifyroom(){
	if(isset($_POST['btnSave'])){
		$roomNum= clean($_POST['rid']);
		$price= clean($_POST['txtPrice']);
		$category_id= clean($_POST['txtCategory']);
		$status= clean($_POST['txtStatus']);
		$booked= clean($_POST['txtBooked']);
		
		if(isRoomExist($roomNum) == '1'){
			$del1 = 'UPDATE tbl_room SET category_id="'.$category_id.'", price="'.$price.'", status="'.$status.'", booked="'.$booked.'" WHERE rowid="'.$roomNum.'"';
			$del = mysqli_query($del1);
			if($del){
				$_SESSION['MOD_ROOM_ERR_MSG'] = '<h3 style="color:green">Room Successfully Modified</h3>';
			}else{
				$_SESSION['MOD_ROOM_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
			}
		}else{
			$_SESSION['MOD_ROOM_ERR_MSG'] = '<h3 style="color:red">Invalid room Number</h3>';
		}
		
	}
	$r = '<table id="tbl_content" >
			<tr>
				<td width="75%" id="tbl_delete_bus">					
				<!-- sub content -->
					<div align="center" class="form_outline_div" style="padding:3% !important;"> 
						<h2 align="center"> Change Room Status</h2>';
						if(isset($_SESSION['MOD_ROOM_ERR_MSG']) && strlen($_SESSION['MOD_ROOM_ERR_MSG'])>0){
							$r .= "<p align='center' class='err_msg'>". $_SESSION['MOD_ROOM_ERR_MSG']. "</p>";
							$_SESSION['MOD_ROOM_ERR_MSG'] = '';
						}
			$r .='		<form method="POST" action="" id="form">
							<table id="tbl_delete_bus" align="center">
								<tr>
									<td> <h3>Enter Room Number</h3> </td>
									<td> <input type="number" name="txtNum" value="" required/> </td>
									<td colspan="2"> <input type="submit" id="btnModifyRoom" name="btnModifyRoom" value="Proceed"/> </td>
								</tr>
							</table>
						</form>
						<!-- end of sub content -->';
						if(isset($_POST['btnModifyRoom'])){
							$roomNum= clean($_POST['txtNum']);
		
							if(isRoomExist($roomNum) == '1'){
								$mod1 = 'SELECT * FROM tbl_room WHERE rowid="'.$roomNum.'"';
								$mod = mysqli_query($mod1);
								$row = mysqli_fetch_assoc($mod);
								$r .= '<br/><br/><h2 align="center"> Update Info</h2>
									<form name="frmAddBus" id="form" method="post" action="" enctype="multipart/form-data">
										<table align="center" style="width:80%; margin:auto;">
											<tr><td>Room Category:</td><td><select name="txtCategory">'.load_roomCategory_into_combo($row['category_id']).'</select></td></tr>
											<tr><td>Room Price:</td><td><input type="text" name="txtPrice" id="txtPrice" value="'.$row['price'].'" /></td></tr>
											<tr><td>Room Status:</td><td><select name="txtStatus">'.loadRoomStatusIntoCombo($roomNum, $row['status']).'</select></td></tr>
											<tr><td>Booked Room Status:</td><td><select name="txtBooked">'.loadBookedRoomIntoCombo($roomNum, $row['booked']).'</select></td></tr>
											<tr><td></td>
											<td style="float:left">
												<br/>
												<input type="submit" name="btnSave" id="btnSave" value="Modify" title="click to save changes"/>
												<input type="hidden" name="rid" value="'.$roomNum.'" />
												<br/><br/>
											</td></tr>
										</table>
									</form>';
							}else{
								$_SESSION['MOD_ROOM_ERR_MSG'] = '<h3 style="color:red">Invalid room Number</h3>';
							}							
						}
			$r .= '	</div>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function load_roomCategory_into_combo($param = ''){
	$r_v = '';

	$q = "SELECT * FROM tbl_room_category ORDER BY category_name DESC";	
	$query = mysqli_query($q);
	$total_rows_found = mysqli_num_rows($query);
	
	if ($total_rows_found > 0){
		$r_v .= "<option value = '-1'>-- Select House Category --</option>";
		while ($row = mysqli_fetch_assoc($query)){
			if($param == $row['category_id']){
				$r_v .= "<option value='" . $row['category_id'] . "' selected>" . $row['category_name'] . "</option>";
				$_SESSION['category'] = $row['category_id'];
			}else{
				$r_v .= "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
				$_SESSION['category'] = $row['category_id'];
			}
		}
	}else{
		$r_v .= "<option value = '-1'>No room available at the moment</option>";
		$_SESSION['category'] = '0';
	}

	return $r_v;
}

function loadRoomStatusIntoCombo($id, $param = ''){
	$r_v = '';

	$q = "SELECT * FROM tbl_room WHERE rowid='$id'";	
	$query = mysqli_query($q);
	$total_rows_found = mysqli_num_rows($query);
	
	if ($total_rows_found > 0){
		$r_v .= "<option value = '-1'>-- Select Room Status --</option>";
		$r_v .= "<option value='open' ";if($param == 'open'){$r_v .= 'selected';}; $r_v .= "> Open </option>";
		$r_v .= "<option value='closed' ";if($param == 'closed'){$r_v .= 'selected';}; $r_v .= "> Closed </option>";
	}else{
		$r_v .= "<option value = '-1'>Room status unavailable at the moment</option>";
	}

	return $r_v;
}

function loadBookedRoomIntoCombo($id, $param = ''){
	$r_v = '';

	$q = "SELECT * FROM tbl_room WHERE rowid='$id'";	
	$query = mysqli_query($q);
	$total_rows_found = mysqli_num_rows($query);
	
	if ($total_rows_found > 0){
		$r_v .= "<option value = '-1'>-- Select Booked Room Status --</option>";
		$r_v .= "<option value='booked' ";if($param == 'booked'){$r_v .= 'selected';}; $r_v .= "> Booked </option>";
		$r_v .= "<option value='unbooked' ";if($param == 'unbooked'){$r_v .= 'selected';}; $r_v .= "> Unbooked </option>";
	}else{
		$r_v .= "<option value = '-1'>Booked Room status unavailable at the moment</option>";
	}

	return $r_v;
}

function isRoomExist($id){
	$q = "SELECT * FROM tbl_room WHERE rowid='".$id."'";
	$q2 = mysqli_query($q);
	$exist= mysqli_num_rows($q2);

	if($exist > 0){
		return '1';
	}else{
		return '0';
	}
}

function deleteroom(){
	if(isset($_POST['btnDeleteRoom'])){
		$roomNum= clean($_POST['txtNum']);
		
		if(isRoomExist($roomNum) == '1'){
			$del1 = 'DELETE FROM tbl_room WHERE rowid="'.$roomNum.'"';
			$del = mysqli_query($del1);
			if($del){
				$_SESSION['DEL_ROOM_ERR_MSG'] = '<h3 style="color:green">Room Successfully Deleted</h3>';
			}else{
				$_SESSION['DEL_ROOM_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
			}
		}else{
			$_SESSION['DEL_ROOM_ERR_MSG'] = '<h3 style="color:red">Invalid room Number</h3>';
		}
		
	}
	$r = '<table id="tbl_content" >
			<tr>
				<td width="75%" id="tbl_delete_bus">					
				<!-- sub content -->
					<div align="center" class="form_outline_div" style="padding:3% !important;"> 
						<h2 align="center"> Delete Room </h2>';
						if(isset($_SESSION['DEL_ROOM_ERR_MSG']) && strlen($_SESSION['DEL_ROOM_ERR_MSG'])>0){
							$r .= "<p align='center' class='err_msg'>". $_SESSION['DEL_ROOM_ERR_MSG']. "</p>";
							$_SESSION['DEL_ROOM_ERR_MSG'] = '';
						}
			$r .='		<form method="POST" action="" id="form">
							<table id="tbl_delete_bus" align="center">
								<tr>
									<td> <h3>Enter Room Number</h3> </td>
									<td> <input type="number" name="txtNum" value="" required/> </td>
									<td colspan="2"> <input type="submit" id="btnDeleteRoom" name="btnDeleteRoom" value="Proceed"/> </td>
								</tr>
							</table>
						</form>
						<!-- end of sub content -->
					</div>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function viewUnbookedRoom(){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS c
				ON r.category_id = c.category_id
				INNER JOIN tbl_block AS b
				ON r.blockId=b.block_id
				WHERE r.reserved="NO" AND r.status="OPEN"
				ORDER BY r.category_id DESC';
	$read = mysqli_query($read1);
	$i = '1';
	$t = '<br/> <div id="divStaff" style="color:#000000;"> <table align="center" width="100%" style="border: 1px solid; text-align:center;font-size:17px;">
			<tr>
				<td colspan="4"> <h2 align="center"> <u> Available Rooms </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> ROOM NO. </th>
				<th> HOSTEL </th>
				<th> BLOCK </th>
				<th> STATUS </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
		$status = $row['status'];
		$t .=	'<tr class="ft">
				<td> Room '.$row["room_name"].' </td>
				<td> '.$row["category_name"].' </td>
				<td> Block '.$row["block_name"].' </td>
				<td>';?> <?php if ($status=='closed')
					$t.= "Occupied";
					elseif ($status=='open') {
					$q = "SELECT COUNT(*) AS count FROM tbl_booking WHERE room_id='".$row['rowid']."'";
			        $q2 = mysqli_query($q) or die(mysqli_error());
			        $row = mysqli_fetch_assoc($q2);
			        echo $row['count'];
					 	$t.= $row['count'] . " Bedspace taken";
					 }?>
				<?php $t.=' </td>
			</tr>'; 
		$i++;
	}
	$t .= '
	<tr><td colspan="7"><button onclick="window.print()">Print</button></td></tr></table> </div> <br/>';
	echo $t;
}

function viewBookedRoom(){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS rc
				INNER JOIN tbl_student AS c
				INNER JOIN tbl_booking AS b
				INNER JOIN tbl_block AS bl
				ON r.category_id = rc.category_id
				AND r.rowid = b.room_id
				AND b.customer_id = c.rowid
				AND r.blockId=bl.block_id WHERE b.paid=1';	
	$read = mysqli_query($read1);	
	$t = '<br/> <div id="divStaff" style="color:#000000;"> <table align="center" width="100%" style="text-align:center;font-size:17px">
			<tr>
				<td colspan="7"> <h2 align="center"> <u> Rooms Booked and Paid </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> Room No. </th>
				<th> Hostel </th>
				<th> Block </th>
				<th> Student </th>
				<th> Reg. No. </th>
				<th> Phone No. </th>
			</tr>';	
			//$numrow=mysqli_num_rows($read);
			$count = mysqli_query("SELECT COUNT(*) AS count FROM tbl_booking WHERE paid=1");
			$crow=mysqli_fetch_assoc($count);
			$rcount= $crow['count'];
			$amount= $rcount*5900;
		if(mysqli_num_rows($read)>0){
	while($row = mysqli_fetch_assoc($read)){
		$roomID=$row["room_id"];
		$_SESSION['roomID']=$roomID;
		$t .=	'<tr class="ft">
				<td> Room '.$row["room_name"].' </td>
				<td> '.$row["category_name"].' </td>
				<td> Block '.$row["block_name"].' </td>
				<td> '.$row["first_name"].' '.$row["other_names"].' </td>
				<td> '.$row["username"].' </td>
				<td> '.$row["mobile_number"].' </td>
			</tr>';
		}$t.='<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
		<tr><td colspan="6"> <b>Total Amount Paid:N </b>'.$amount.'</td></tr>
		<tr>
			</tr>
			<tr><td colspan="7"><button onclick="window.print()">Print</button></td></tr>';
		}
	else{
			$t.='<td colspan="7" style="color:red;">No Data in reserved rooms</td></tr>';
		
	}
	$t .= '</table> </div> <br/>';
	return $t;
}

function viewCustomerBookedRoom($id){
	$_SESSION['cus_user_id'];
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS rc
				INNER JOIN tbl_student AS c
				INNER JOIN tbl_booking AS b
				ON r.category_id = rc.category_id
				AND r.rowid = b.room_id
				AND b.customer_id = c.rowid WHERE r.reserved="YES" AND b.customer_id="'.$_SESSION['cus_user_id'].'"
				ORDER BY b.date_reserved DESC';
	$read = mysqli_query($read1) or die(mysqli_error());
	$i = '1';
	$t = '<br/> <div id="divStaff"> <table align="center" width="100%" style="text-align:center;font-size:17px">
			<tr>
				<td colspan="7"> <h2 align="center"> <u> Reserved Rooms </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> ROOM NO. </th>
				<th> Hostel </th>
				<th> Payment Status </th>
				<th> Date </th>
				<th>Ticket No. </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
		$t .=	'<tr class="ft">
				<td> '.$row["room_name"].' </td>
				<td> '.$row["category_name"].' </td>';
				if ($row['paid']==0) {
				$t.= '<td>Not Paid <a href="payment.php" target="_blank">Pay Now</a></td>';
				}else{
				$t.= '<td>Paid</td>';
				}
				
		$t .=	'<td> '.$row["date_reserved"].' </td>
				<td> '.$row["ticket_id"].' </td>
				
			</tr>';
	}
	$t .= '</table> </div> <br/>';
	echo $t;
}

function viewResRoom(){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS rc
				INNER JOIN tbl_student AS c
				INNER JOIN tbl_booking AS b
				INNER JOIN tbl_block AS bl
				ON r.category_id = rc.category_id
				AND r.rowid = b.room_id
				AND b.customer_id = c.rowid
				AND r.blockId=bl.block_id WHERE b.paid=0
				GROUP BY r.category_id
				ORDER BY b.date_reserved DESC';	
	$read = mysqli_query($read1);	
	$t = '<br/> <div id="divStaff" style="color:#000000;"> <table align="center" width="100%" style="text-align:center;font-size:17px">
			<tr>
				<td colspan="7"> <h2 align="center"> <u> Rooms Booked and Unpaid</u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> Room No. </th>
				<th> Hostel </th>
				<th> Block </th>
				<th> Student </th>
				<th> Reg. No. </th>
				<th> Phone No. </th>
				<th> Action </th>
			</tr>';	
			if(mysqli_num_rows($read)>0){
	while($row = mysqli_fetch_assoc($read)){
		$t .=	'<tr class="ft">
				<td> Room '.$row["room_name"].' </td>
				<td> '.$row["category_name"].' </td>
				<td> Block '.$row["block_name"].' </td>
				<td> '.$row["first_name"].' '.$row["other_names"].' </td>
				<td> '.$row["username"].' </td>
				<td> '.$row["mobile_number"].' </td>
				<td><a href="cancel.php?id='.$row['rowid'].'">Cancel</a></td>
			</tr>
			<tr>
				<td colspan="7" cellspacing="10px" cellpadding="10px"></td>
			</tr>
			<tr><td colspan="7"><button onclick="window.print()">PRINT</button></td></tr>'; 
	
	$t .= '</table> </div> <br/>';
	}
  }else{
  	$t.='<tr class="ft"><td colspan="7" style="color:red;">No Data for this Selection</td></tr>';
  }
  return $t;
}


function addroute(){
	if(isset($_POST['btnAddRoute'])){
		$src = clean($_POST['txtRouteSource']);
		$dest = clean($_POST['txtRouteDest']);
		
		$add1 = 'INSERT INTO tbl_route (source, destination) VALUES("'.$src.'", "'.$dest.'")';
		$add = mysqli_query($add1);
		if($add){
			$_SESSION['ADD_ROUTE_ERR_MSG'] = '<h3 style="color:green">Route Successfully Added</h3>';
		}else{
			$_SESSION['ADD_ROUTE_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
		}
	}
	$r = '<table id="tbl_content">
			<tr>
				<td width="75%">';
						if(isset($_SESSION['ADD_ROUTE_ERR_MSG']) && strlen($_SESSION['ADD_ROUTE_ERR_MSG'])>0){
							echo "<p align='center' class='err_msg'>". $_SESSION['ADD_ROUTE_ERR_MSG']. "</p>";
							$_SESSION['ADD_ROUTE_ERR_MSG'] = '';
						}
					// sub content -->
			$r .=		'<div class="form_outline_div">
						<h1>Add New Route</h1>
						<form name="frmAddRoute" id="form" method="post" action="">
						<table align="center">
							<tr><td>Route Source:</td><td><input type="text" name="txtRouteSource" id="txtRouteSource" required /></td></tr>
							<tr><td>Route Destination:</td><td><input type="text" name="txtRouteDest" id="txtRouteDest" required /></td></tr>
							<tr><td></td>
							<td style="float:left">
								<input type="submit" name="btnAddRoute" id="btnAddRoute" value="Add" title="click to add route"/>
							</td></tr>
						</table>
						</form>
					</div>
					<!-- end of sub content -->
					<br/>
				</td>
					
			</tr>
		</table>';
	echo $r;
}

function deleteroute(){
	if(isset($_POST['btnDeleteRoute'])){
		$src = clean($_POST['txtRouteSource']);
		$dest = clean($_POST['txtRouteDest']);
		
		$del1 = 'DELETE FROM tbl_route WHERE source="'.$src.'" AND destination="'.$dest.'"';
		$del = mysqli_query($del1);
		if($del){
			$_SESSION['DELETE_ROUTE_ERR_MSG'] = '<h3 style="color:green">Route Successfully Deleted</h3>';
		}else{
			$_SESSION['DELETE_ROUTE_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
		}
	}
	$r = '<table id="tbl_content">
		<tr>
			<td width="75%">';
					if(isset($_SESSION['DELETE_ROUTE_ERR_MSG']) && strlen($_SESSION['DELETE_ROUTE_ERR_MSG'])>0){
						echo "<p align='center' class='err_msg'>". $_SESSION['DELETE_ROUTE_ERR_MSG']. "</p>";
						$_SESSION['DELETE_ROUTE_ERR_MSG'] = '';
					}
				// sub content -->
		$r .=		'<div class="form_outline_div">
					<h1>Delete Route</h1>
					<form name="frmDeleteRoute" id="form" method="post" action="">
					<table align="center">
						<tr><td>Route Source:</td><td><input type="text" name="txtRouteSource" id="txtRouteSource" required /></td></tr>
						<tr><td>Route Destination:</td><td><input type="text" name="txtRouteDest" id="txtRouteDest" required /></td></tr>
						<tr><td></td>
						<td style="float:left">
							<input type="submit" name="btnDeleteRoute" id="btnDeleteRoute" value="Delete" title="click to delete route"/>
						</td></tr>
					</table>
					</form>
				</div>
				<!-- end of sub content -->
				<br/>
			</td>
				
		</tr>
		</table>';
	echo $r;
}

function cancel(){
	if(isset($_POST['btnDeleteRoute'])){
		$src = clean($_POST['txtRouteSource']);
		
		$del1 = 'DELETE FROM tbl_booking WHERE ticket_id="'.$src.'"';
		$del = mysqli_query($del1);
		if($del){
			$_SESSION['DELETE_ROUTE_ERR_MSG'] = '<h3 style="color:green">Reservation Successfully Deleted</h3>';
		}else{
			$_SESSION['DELETE_ROUTE_ERR_MSG'] = '<h3 style="color:red">Request Unsuccessful</h3>';
		}
	}
	$r = '<table id="tbl_content">
		<tr>
			<td width="75%">';
					if(isset($_SESSION['DELETE_ROUTE_ERR_MSG']) && strlen($_SESSION['DELETE_ROUTE_ERR_MSG'])>0){
						echo "<p align='center' class='err_msg'>". $_SESSION['DELETE_ROUTE_ERR_MSG']. "</p>";
						$_SESSION['DELETE_ROUTE_ERR_MSG'] = '';
					}
				// sub content -->
		$r .=		'<div class="form_outline_div">
					<h1>Delete Reservation</h1>
					<form name="frmDeleteRoute" id="form" method="post" action="">
					<table align="center">
						<tr><td>Enter Ticket ID:</td><td><input type="hidden" name="txtRouteSource" id="txtRouteSource" required /></td></tr>
						<tr><td></td>
						<td style="float:left">
							<input type="submit" name="btnDeleteRoute" id="btnDeleteRoute" value="Delete" title="click to delete reservation"/>
						</td></tr>
					</table>
					</form>
				</div>
				<!-- end of sub content -->
				<br/>
			</td>
				
		</tr>
		</table>';
	echo $r;
}

function view_staff(){
	$read1 = 'SELECT * FROM tbl_staff ORDER BY rowid ASC';
	$read = mysqli_query($read1);
	$t = '<br/> <div id="divStaff"> <table align="center" id="tblStaff">
			<tr>
				<td colspan="5"> <h2> <u> Staff List </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> S/N </th>
				<th> NAMES </th>
				<th> EMAIL ADDRESS </th>
				<th> MOBILE NUMBER </th>
				<th> STAFF ID </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
	$t .=	'<tr class="ft">
			<td> '.$row["rowid"].' </td>
			<td> '.$row["first_name"].' '.$row["other_names"].' </td>
			<td> '.$row["email_address"].' </td>
			<td> '.$row["mobile_number"].' </td>
			<td> '.$row["staff_id"].' </td>
		</tr>'; 
	}
	$t .= '</table> </div> <br/>';
	echo $t;
}

function viewroom(){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS c
				ON r.category_id = c.category_id
				INNER JOIN tbl_block AS b
				ON r.blockId=b.block_id
				WHERE r.reserved="YES"
				ORDER BY r.category_id DESC';
	$read = mysqli_query($read1);
	$t = '<br/> <div id="divStaff" style="color:#000000;"> <table align="center" width="100%" style="border: 1px solid; text-align:center;font-size:17px color:#000000;">
			<tr>
				<td colspan="5"> <h2> <u> Reserved Rooms </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> ROOM NO. </th>
				<th> HOSTEL </th>
				<th> BLOCK </th>
				<th> STATUS </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
		$status = $row['status'];
		$roomID = $row['rowid'];
		$t .=	'<tr class="ft">
				<td> '.$row["room_name"].' </td>
				<td> '.$row["category_name"].' </td>
				<td> '.$row["block_name"].' </td>
				<td>';?> <?php if ($status=='closed')
					$t.= "Occupied";
					elseif ($status=='open') {
					$q = "SELECT COUNT(*) AS count FROM tbl_booking WHERE room_id='$roomID'";
			        $q2 = mysqli_query($q) or die(mysqli_error());
			        $row = mysqli_fetch_assoc($q2);
			        echo $row['count'];
					 	$t.= $row['count'] . " Bedspace taken";
					 }?>
				<?php $t.=' </td></tr>

				<tr><td colspan="7"><button onclick="window.print()">Print</button></td></tr>'; 
	}
	$t .= '</table> </div> <br/>';
	echo $t;
}

function viewCustomerByRoom(){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS rc
				INNER JOIN tbl_student AS c
				INNER JOIN tbl_booking AS b
				ON r.category_id = rc.category_id
				AND r.rowid = b.room_id
				AND b.customer_id = c.rowid
				WHERE b.datetime_checked_out > CURDATE()
				GROUP BY r.rowid
				ORDER BY b.rowid ASC';
	$read = mysqli_query($read1);
	$i = '1';
	$t = '<br/> <div id="divStaff"> <table align="center" width="100%" style="text-align:center;font-size:17px">
			<tr>
				<td colspan="7"> <h2 align="center"> <u> Room List </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> S/N </th>
				<th> NAMES </th>
				<th> GENDER </th>
				<th> EMAIL ADDRESS </th>
				<th> MOBILE NUMBER </th>
				<th> CHECKED IN </th>
				<th> CHECKED OUT </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
		$t .=	'<tr class="ft">
				<td> '.$i.' </td>
				<td> '.$row["first_name"].' '.$row["other_names"].'</td>
				<td> '.$row["gender"].' </td>
				<td> '.$row["email_address"].' </td>
				<td> '.$row["mobile_number"].' </td>
				<td> '.$row["datetime_checked_in"].' </td>
				<td> '.$row["datetime_checked_out"].' </td>
			</tr>'; 
		$i++;
	}
	$t .= '</table> </div> <br/>';
	echo $t;
}

function viewCustomerByRoomID($id){
	$read1 = 'SELECT * 
				FROM tbl_room AS r
				INNER JOIN tbl_room_category AS rc
				INNER JOIN tbl_student AS c
				INNER JOIN tbl_booking AS b
				ON r.category_id = rc.category_id
				AND r.rowid = b.room_id
				AND b.customer_id = c.rowid
				WHERE b.datetime_checked_out > CURDATE()
				AND b.room_id = "'.$id.'"
				GROUP BY r.rowid
				ORDER BY b.rowid ASC';
	$read = mysqli_query($read1);
	$i = '1';
	$t = '<br/> <div id="divStaff"> <table align="center" width="100%" style="text-align:center;font-size:17px">
			<tr>
				<td colspan="7"> <h2 align="center"> <u> Room List </u> </h2> </td>
			</tr>
			<tr id="ht">
				<th> S/N </th>
				<th> NAMES </th>
				<th> GENDER </th>
				<th> EMAIL ADDRESS </th>
				<th> MOBILE NUMBER </th>
				<th> CHECKED IN </th>
				<th> CHECKED OUT </th>
			</tr>';
	while($row = mysqli_fetch_assoc($read)){
		$t .=	'<tr class="ft">
				<td> '.$i.' </td>
				<td> '.$row["first_name"].' '.$row["other_names"].'</td>
				<td> '.$row["gender"].' </td>
				<td> '.$row["email_address"].' </td>
				<td> '.$row["mobile_number"].' </td>
				<td> '.$row["datetime_checked_in"].' </td>
				<td> '.$row["datetime_checked_out"].' </td>
			</tr>'; 
		$i++;
	}
	$t .= '</table> </div> <br/>';
	echo $t;
}

function get_seat_numbers($capacity, $rid){
	$q = "SELECT bs.img
			FROM tbl_bus AS bs
			INNER JOIN tbl_booking AS b
			INNER JOIN tbl_bus_route AS br
			ON b.route_id = br.rowid
			AND br.bus_id = bs.rowid
			WHERE br.departure_date>=CURDATE()
			AND b.route_id='".$rid."'";
	$q2 = mysqli_query($q);
	$row = mysqli_fetch_assoc($q2);
	echo "<img src='".$row['img']."' />";
}

 function updateHostel($dissubproduct1, $rm_limit){
        global $con;
        $v = $con;
        $q = "SELECT COUNT(*) AS count FROM tbl_booking WHERE room_id='$dissubproduct1'";
        $q2 = mysqli_query($q) or die(mysqli_error());
        $row = mysqli_fetch_assoc($q2);
        if ($row['count']==$rm_limit) {
            mysqli_query("UPDATE `tbl_room` SET `status` = 'closed' WHERE `tbl_room`.`rowid`= '$dissubproduct1'") or die(mysqli_error());
        }
    }

function get_user_valid_ticket($ticketID){
	$read1 = 'SELECT *, r.rowid AS rid
                FROM tbl_booking AS b 
                INNER JOIN tbl_student AS c 
                INNER JOIN tbl_room AS r
                INNER JOIN tbl_room_category AS rc
                INNER JOIN tbl_block AS bl
                ON r.rowid=b.room_id 
                AND r.category_id = rc.category_id
                AND b.customer_id=c.rowid
                AND b.blockID=bl.block_id 
                WHERE b.ticket_id="'.$ticketID.'"';
	$read = mysqli_query($read1);
	$row = mysqli_fetch_assoc($read);
	 $_SESSION['ticket_id'] = $row['ticket_id'];
	 $_SESSION['roid'] = $row['rowid']; 
	if ($row['paid']==1){
					 $res= ' Paid';
				}else
					$res= 'Not Paid. Click <a href="payment.php" target="_blank">Here</a> to make payment';
		$r = '<br/> <div id="divTicket"> <table style="text-align: left;" id="tblTicket">
				<tr>
					<td colspan="2"> <div id="print_header" style="color:#000000;">SAMARU COLLEGE OF AGRICULTURE<br/><br/> HOSTEL ALLOCATION SYSTEM</div> </td>
				</tr>
				<tr>
				<br>
					<td colspan="2"> <div id="lblTicketName">'.$row["first_name"].' '.$row["other_names"].'</div> </td>
				</tr>
				<tr>
					<td class="ftd"> Ticket ID </td>
					<td class="std" style="text-align: left;"> '.$row["ticket_id"].' </td>
				</tr>
				<tr>
					<td class="ftd"> Gender </td>
					<td class="std" style="text-align: left;"> '.$row["gender"].' </td>
				</tr>
                <tr>
					<td class="ftd"> Hostel </td>
					<td class="std" style="text-align: left;"> '.$row["category_name"].' </td>
				</tr>
				<tr>
					<td class="ftd"> Block </td>
					<td class="std" style="text-align: left;">Block  '.$row["block_name"].' </td>
				</tr>
				<tr>
					<td class="ftd"> Room Number </td>
					<td class="std" style="text-align: left;"> Room '.$row["room_name"].' </td>
				</tr>
				<tr>
					<td class="ftd"> Payment Status </td>
					<td class="std" style="text-align: left;"> '.$res.' </td>
				</tr>		
				<tr>
					<td colspan="2"></td>
				</tr>
			 </table> </div> 
			 <h3 align="center"><input type="submit" id="btnPrintT" name="btnPrintT" value="Print"/></h3> <br/>
			 <script>
				$(document).ready(function(){
					$("#btnPrintT").click(function(){
						$("#cssmenu").hide();
						$("#btnPrintT").hide();
						window.print();
					});
				});
			 </script>';
	echo $r;
}

function load_search_result($sd, $ed){
	$r = '<table class="table table-bordered table-condensed table-striped" style="width:95%">';
	$q = "SELECT * 
                    FROM tbl_room_category AS rc
                    INNER JOIN tbl_booking AS b
                    INNER JOIN tbl_room AS r
                    ON rc.category_id = r.category_id
                    AND b.room_id = r.rowid
                    WHERE datetime_checked_in <> '".$sd."'
                    AND datetime_checked_out <> '".$ed."'
                    AND r.status='open'";
	$query = mysqli_query($q);
	$total_rows_found = mysqli_num_rows($query);

	if ($total_rows_found > 0){
		$r .= '<tr style="text-align:center"><td colspan="3" class="table_header"><p align="center">Search Result  Between '.$sd.' and  '.$ed.'</p></td></tr>';

		$r .= '<tr>
			<td width="5%" style="align:center"><strong>SN</strong></td>
			<td><strong>ROOM CATEGORY</strong></td>
			<td><strong>PRICE</strong></td>
		</tr>';
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)){
			$i++;
			$r .= '<tr><td>' . $i . '<td>' . $row['category_name']. '</td><td> #' . $row['price'] . '</td></tr>';
		}

	}else{
		$r .= '<tr style="text-align:center; color:#ff3333 !important"><td colspan="3" class="table_header">NO RECORDS OF YOUR SEARCH IS AVAILABLE AT THE MOMENT</td></tr>';
	}

	$r .= '</table>';
	return $r;
}

function getRoomNumber(){
	$q = "SELECT * FROM tbl_room ORDER BY rowid ASC";
	$q2 = mysqli_query($q);
	$r = "<option value='0'> Select your room number </option>";
	
	while($row = mysqli_fetch_assoc($q2)){
		if(isRoomOccupied($row['rowid'])){

		}else{
			$w = "<option id='".$row['rowid']."'>".$row['rowid']."</option>";
			$r .= $w;
		}
	}

	return $r;
}

function getRoomNumberByCategory($catId){
	$q = "SELECT * FROM tbl_room WHERE blockId='".$catId."' AND status='open' ORDER BY rowid ASC";
	$q2 = mysqli_query($q);

	if(mysqli_num_rows($q2) > 0){
		$r = "<option value='0'> Select your room number </option>";
		
		while($row = mysqli_fetch_assoc($q2)){
			if(isRoomOccupied($row['rowid'])){
				$r = "<option value='0'> - </option>";
				$r .= "<option value='0'> No room available for this Hostel at the moment </option>";
			}else{
				$w = "<option value='".$row['rowid']."'>".$row['room_name']."</option>";
				$r .= $w;
			}
		}
	}else{
		$r = "<option value='0'> - </option>";
		$r .= "<option value='0'> No room available for this category at the moment </option>";
	}

	return $r;
}

function getRoomBlocks($catId){
	$q = "SELECT * FROM tbl_block WHERE roomCatID='".$catId."'";
	$q2 = mysqli_query($q);

	if(mysqli_num_rows($q2) > 0){
		$r = "<option value='0'> Select your room number </option>";
		
		while($row = mysqli_fetch_assoc($q2)){
			
				$w = "<option value='".$row['block_id']."'>".$row['block_name']."</option>";
				$r .= $w;
			
		}
	}else{
		$r = "<option value='0'> - </option>";
		$r .= "<option value='0'> No room available for this category at the moment </option>";
	}

	return $r;
}


function isRoomOccupied($rid){
	$q = "SELECT room_id FROM tbl_booking WHERE room_id='$rid' AND datetime_checked_out>=CURDATE()";
	$q2 = mysqli_query($q);
	
	if(mysqli_num_rows($q2) > 0){
		return true;
	}else{
		return false;
	}
}

function isRoomID($rid){
	$q = "SELECT * FROM tbl_room WHERE rowid='".$rid."'";
	$q2 = mysqli_query($q);
	
	if(mysqli_num_rows($q2) > 0){
		return '1';
	}else{
		return '0';
	}
}

?>