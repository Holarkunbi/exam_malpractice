				<?php
							include('../assets/functions.php');
							global $con;
							$v = $con;
							$value=$_REQUEST['value'];
							
							$query="SELECT course_id, course_name, deptID FROM tbl_course WHERE deptID='$value' ORDER BY course_id";
							$q2 = mysqli_query($v, $query);
							while($prdrow=mysqli_fetch_assoc($q2)){
							$tt=$prdrow['reg_no'];
							$idr=$prdrow['course_name'];
							$idrr=$prdrow['fname'];
							$id=$prdrow['course_id'];
							print "
							<option value='$id'>$id ($idr)</option>";
							}																			
							?>