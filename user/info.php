<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-user.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/ip.php';
//session_start();
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
		$username= veifycookies($_COOKIE["bwuser"]);
		$rs=loaddb("select lastip,lastlogindate,regdate from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
		$row1=mysqli_fetch_array($rs);
		$lastip=$row1['lastip'];
		$lastloc=getIPLoc($lastip);
		$lastlogindate=$row1['lastlogindate'];
		$regdate=$row1['regdate'];
		$lowftp=getthesettings('lowftpper');
		$optftp=getthesettings('optftp');
		$opsh=getthesettings('opensh');
		if($optftp==1){
			if($_SESSION['permission']>=$lowftp){
				$str1="有";
			}else{
				$str1="无";
			}
		}else{
				$str1="不适用";
			}
	  
		
		switch($_SESSION['permission']){
				case '1':
				$userqx="普通用户";
				  break;
				case '2':
				$userqx="高级用户";
				  break;
				case '3':
				$userqx="VIP";
				  break;
				case '4':
				$userqx="管理员";
				  break;
				 default:
				$userqx="未知";
				  break;
			}
	  }else{
		  echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
			exit; 
	  }
         
?>
<body>
 <div class="container" >
 <br>
 <!--
 标题
 -->
	  <h2>用户信息</h2> 
	  <hr>
	   <div class="container" >
	   <p class="lead">
	   <?php
	   echo "
	   用户名：$username<br>
	   组别：$userqx<br>
	   ";
	   if($optftp==1){echo "是否有FTP：$str1<br>";}
       echo "注册时间：$regdate<br>
	   上次登录时间：$lastlogindate <br>
	   上次登录IP及地区：$lastip $lastloc<br>";?></p>
     <!--  <a href="emailsend.php"><button type="button" class="btn btn-primary">电邮联系</button></a>  -->
		<?php if($optftp==1){echo '<a href="ftp.php"><button type="button" class="btn btn-primary">查看FTP账户信息</button></a>';} ?>
		<?php if($opsh==1){echo '<a href="admituser.php"><button type="button" class="btn btn-primary">用户组更改</button></a>';} ?>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';?>
</html>