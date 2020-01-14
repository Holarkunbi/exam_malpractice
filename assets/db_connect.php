<?php

    $link = mysql_connect("localhost", "root", "") or die(mysql_error());

        mysql_select_db('db_exam_malpractice')
                or die("<br/><br/> <p style='color:red; font-size:20px; text-align:center;'> Failed to select database. . . </p> <br/><br/>".mysql_error());
  
?>