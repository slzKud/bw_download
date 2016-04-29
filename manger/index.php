<html>
<?php 
$nowpageid=1;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
?>
<body>
<div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-xs-9 text-left">
	  <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">
         仪表盘
      </h3>
   </div>
   <div class="panel-body">
    <div class="container">
      <h1>欢迎！<small><?php echo veifycookies($_COOKIE["bwuser"]);?></small></h1>
	   <div class="container">
	
	   </div>
	  </div>
   </div>
</div>
</div>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>
