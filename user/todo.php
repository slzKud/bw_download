<?php 
//引入网页内容
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
session_start();
//自动判断cookie
	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if ($_SESSION['permission']==0){
	  $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
	  $row=mysqli_fetch_array($con);
     $_SESSION['permission']=$row['permission'];
	 }
	  if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
	       echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		   exit;
	   }
		empty($_POST['type']) && $_POST['type']="other";
        switch($_POST['type']){
            case "changeftppass":
               empty($_POST['pass']) &&$_POST['pass']="";  
               if($_POST['pass']==""){
                   echo "no pass";
                   exit;
               }
            $username=veifycookies($_COOKIE["bwuser"]);
            $passmd5=md5($_POST['pass']);
            loaddb("UPDATE bw_ftp SET password='$passmd5' where userid='$username'");
            echo "ok";
                   exit;
            break;
  default:
            echo "no type";
            exit;

        }
	  }else{
		  echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
			exit; 
	  }
         
?>