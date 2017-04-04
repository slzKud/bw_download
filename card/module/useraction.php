<?
include_once 'mysqlaction.php';
 function getper() {
       $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwcard"])."'");
	  $row=mysqli_fetch_array($con);
	 return $row['permission'];
 }
 
?>