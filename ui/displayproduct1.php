				<?php
							include('../assets/functions.php');
							global $con;
							$v = $con;
							$value=$_REQUEST['value'];
							
							$query="SELECT reg_no, lname, fname FROM tbl_student WHERE stud_dept='$value' ORDER BY reg_no";
							$q2 = mysqli_query($v, $query);
							while($prdrow=mysqli_fetch_assoc($q2)){
							$tt=$prdrow['reg_no'];
							$idr=$prdrow['lname'];
							$idrr=$prdrow['fname'];
							$id=$prdrow['reg_no'];
							print "
							<option value='$id'>$tt ($idrr $idr)</option>";
							}																			
							?>