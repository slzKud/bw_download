<?php
header('P3P: CP="ALL ADM DEV PSAi COM OUR OTRo STP IND ONL"');
include_once  dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once  dirname(dirname(__FILE__)).'/module/ip.php';
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
	   error_reporting(E_ALL & ~E_NOTICE);
		if(getthesettings("blocknotinchina")==="1" && $loginflag==0){
			$ip_user=get_IP();
			$loc= getIPLocCode($ip_user);
			if (isset($_COOKIE["bwuser"])){$usern=veifycookies($_COOKIE["bwuser"]);}else{$usern="incorrect!";}
			//echo($loc);
			if($loc!="CN" && $loc!="LOCAL"){
				if(!Get_Userexpect($usern)){
					header("Maintenance: 2");
					header("location:../countryblock.php");
					exit;
				}
			}else{
				if(Get_IPBanList($ip_user)){
					header("Maintenance: 2");
					header("location:../countryblock.php");
					exit;
				}
			}
		}
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
right: 72px;
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
				 <div id="user-info">
   </div>  
	 <div class="collapse navbar-collapse" id="example-navbar-collapse">
      <ul class="nav navbar-nav">
	  <!--
		 <li><a href="/">主页</a></li>
		 <li><a href="/downlist.php">资源列表</a></li>
		  <li><a href="/nowdiff.php">最近新增</a></li>
		  -->
		  <li> <a href="../">返回资源区</a></li>
		 <li> <a href="http://betaworld.cn">返回社区</a></li>
      </ul>
	     
       </div>
    </div>
   </nav>