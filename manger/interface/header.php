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
      <title>BetaWorld��Դ��</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- ���� Bootstrap -->
      <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

      <!-- HTML5 Shim �� Respond.js ������ IE8 ֧�� HTML5Ԫ�غ�ý���ѯ -->
      <!-- ע�⣺ ���ͨ�� file://  ���� Respond.js �ļ�������ļ��޷���Ч�� -->
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
                <a class="navbar-brand" href="/">BetaWorld��Դ������վ</a>
				</div>
			
          <div id="user-info">
          <p class="navbar-text pull-right">
            <?php
	  //�Զ��ж�cookie

	  if (isset($_COOKIE["bwuser"])){
	  //�����û�����
	  if(veifycookies($_COOKIE["bwuser"])!="incorrect��"){
	
      echo "<p class='navbar-text navbar-right'>���, <a href='/user/info.php' class='navbar-link'>".veifycookies($_COOKIE["bwuser"])."</a>.<a href='/user/login.php?type=logout' class='navbar-link'>����˳�</a>.</p>";
       }
	   }else{
		    echo "<a href='/user/login.php' class='navbar-link'>����</a>";
			} 
         
       ?>
</nav>
   </div>  
	
    </div>
   
   <br>