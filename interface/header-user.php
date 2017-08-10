<?php
header('P3P: CP="ALL ADM DEV PSAi COM OUR OTRo STP IND ONL"');
?>
<?php 
session_start();	
 date_default_timezone_set("PRC");  
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
empty($_SESSION['permission'])&&$_SESSION['permission']=0;
$SESSION=0;
//echo $_SESSION['permission'];
?>
<head>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>BetaWorld资源区</title>

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- 引入 Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
	  <style>
	  body {
			font-family: 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
			padding-top: 50px;
			padding-bottom: 50px;
		}
	  @media(max-width:767px) { 
 #user-info {
position: absolute;
top:0px;
right: 80px;
} }

</style>
   </head>
   <body>
   <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                <span class="icon-bar"></span>
				<span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">BetaWorld资源区</a>
				</div>
				 <div >

         <li class='dropdown navbar-text pull-right nav navbar-nav' id="user-info">
		  <?php
	  //自动判断cookie
	  $baned=0;
	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if ($_SESSION['permission']==0){
	  $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
	  //echo "select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'";

	  $row=mysqli_fetch_array($con);
     $_SESSION['permission']=$row['permission'];
	 $SESSION=$row['permission'];
	 }
	  if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
      echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class='glyphicon glyphicon-user'></span> ".veifycookies($_COOKIE["bwuser"])."<b class='caret'></b></a>.
	   <ul class='dropdown-menu'>       
	   <li><a href='/user/index.php' class='navbar-link'><span class='glyphicon glyphicon-tag'></span> 个人中心</a></li>
		 <li><a href='/feedback.php' class='navbar-link'><span class='glyphicon glyphicon-Comment'></span> 反馈</a></li>";
		 if($_SESSION['permission']==4){echo "<li><a href='/manger/index.php' class='navbar-link'><span class='glyphicon glyphicon-cog'></span> 管理站</a></li>";}
		 echo "<li><a href='/user/login.php?type=logout' class='navbar-link'><span class='glyphicon glyphicon-log-out'></span> 退出</a></li>
         </ul>";
	
		 //如果被封禁
		  if ($_SESSION['permission']==-1){
			   //查找封禁记录
		 $rschk=loaddb("SELECT * FROM bw_baneduser where username='".veifycookies($_COOKIE["bwuser"])."' and ifclose=1");
		//echo "SELECT * FROM bw_baneduser where username='".veifycookies($_COOKIE["bwuser"])."' and ifclose=1";
		 if(mysqli_num_rows($rschk) >0){
			// echo "t1";
			 //如果存在，检查时间
			 $row=mysqli_fetch_array($rschk);
			 if($row['btime']==-1){
				 //echo "t2";
				 $baned=2;
			 }else{
				  if($row['btime']>time() and $baned!=2 ){
				 //确认被封禁
				 	$baned=1;	
					$timeuto=$row['btime'];
			 }else{
				 $usern=veifycookies($_COOKIE["bwuser"]);
				 $sql="update bw_usertable SET permission=1 where username='$usern'";
				 //echo $sql;
				 loaddb($sql);
				  $sql="update bw_baneduser SET ifclose=0 where username='$usern' and ifclose=1";
				 loaddb($sql);
				 $baned=0;
				 session_unset();
				  $_SESSION['permission']=1;
			   }
			   }
			
		  }
       }
	   }
	  }else{
		   	 $_SESSION['permission']=0;
		    echo '<a href="/user/login.php" class="navbar-link"><span class="glyphicon glyphicon-user"></span> 登入</a>';} 
			if(file_exists("Maintenance") || file_exists("Maintenance.txt") ||//判断是否维护状态，如果是；页面跳转
		   file_exists("maintenance") || file_exists("maintenance.txt") || getthesettings("optmode")==="1"
		)
		{
			if($_SESSION['permission']<4){
				header("Maintenance: 1");
			header("location:../mainteninfo.php");
			exit;
			}
			
		}
       ?>
	   
	   </li>

   </div>  
      
	 <div class="collapse navbar-collapse" id="example-navbar-collapse">
      <ul class="nav navbar-nav">
	  
		<li> <a href="../">返回资源区</a></li>
		 <li> <a href="http://betaworld.cn">返回社区</a></li>
		 </ul>
		
	     
       </div>
    </div>
   </nav>
   <?php
  // echo $baned;
   if($baned==1){
	   $timeto=unixtime_to_date($timeuto);
	   $LErr="很抱歉，你已经被管理员封禁，解封时间是$timeto 。";
	   echo '<div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>Opps...</h2> 
	  <hr>
	  <br>
<div class="alert alert-danger">'.$LErr.'</div>

	  <br><br>
	  
<br>
</div>';
exit;
   }
   if($baned==2){
	   $LErr="很抱歉，你已经被管理员永久封禁。" ;
	    echo '<div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>Opps...</h2> 
	  <hr>
	  <br>
	<div class="alert alert-danger">'.$LErr.'</div>
	  <br><br>
	  
<br>
</div>';
exit;
   }
   function unixtime_to_date($unixtime, $timezone = 'PRC') {
    $datetime = new DateTime("@$unixtime"); //DateTime类的bug，加入@可以将Unix时间戳作为参数传入
    $datetime->setTimezone(new DateTimeZone($timezone));
    return $datetime->format("Y-m-d H:i:s");
}
   ?>