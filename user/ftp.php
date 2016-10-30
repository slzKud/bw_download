<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-nomenu.php';
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
		$username= veifycookies($_COOKIE["bwuser"]);
		$lowftp=getthesettings('lowftp');
		$optftp=getthesettings('optftp');
		$ftpadress=getthesettings('ftpserveradress');
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
 <?php 
 if($optftp==1){
	 if($lowftp <= $_SESSION['permission']){
		 echo "
		   <h2>FTP信息</h2> 
	  <hr>
	   <div class=container >
	   <h3>BetaWorld FTP现在可用！</h3>
	   <p class=lead>
	   服务器地址：$ftpadress<br>
	   用户名：$username<br>
       密码：跟资源区密码相同<br>
	  </p>
       
</div>";
	 }else{
		echo '
		   <h2>FTP信息</h2> 
	  <hr>
	   <div class="container" >
	   <h3>BetaWorld FTP现在可用！</h3>
	   <p class="lead">
	   对不起，你暂时无法使用FTP服务。<br>
	  </p>
	  </div>
       '; 
	 }
 }else{
	 echo '
	   <div class="container" >
	   <h3>BetaWorld FTP现在不可用！</h3>
	   </div>
       '; 
	 }
 ?>
	<a href="info.php"><button type="button" class="btn btn-primary"><返回个人信息</button></a>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';?>
</html>