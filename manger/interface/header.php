<?php 	  
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
session_start();
empty($_SESSION['permission'])&&$_SESSION['permission']=0;
function https($num) { 
$http = array ( 
403 => "HTTP/1.1 403 Forbidden", 
); 
header($http[$num]); 
} 
?>
   <head>
      <title>BetaWorld资源区</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- 引入 Bootstrap -->
      <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

      <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
	  <style>
	  body {
			font-family: 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                <span class="icon-bar"></span>
				<span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">BetaWorld资源区管理站</a>
				</div>
			
          <div id="user-info">
          <p class="navbar-text pull-right">
            <?php
	  //自动判断cookie

	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
	
      echo "<p class='navbar-text navbar-right'>你好, <a href='/user/info.php' class='navbar-link'>".veifycookies($_COOKIE["bwuser"])."</a>.<a href='/user/login.php?type=logout' class='navbar-link'>点此退出</a>.</p>";
       }
	   }else{
		    echo "<a href='/user/login.php' class='navbar-link'>登入</a>";
			} 
         
       ?>
</nav>
   </div>  
	
    </div>
   
   <br>