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
         �Ǳ���
      </h3>
   </div>
   <div class="panel-body">
    <div class="container">
      <h1>��ӭ��<small><?php echo veifycookies($_COOKIE["bwuser"]);?></small></h1>
	   <div class="container">
	
	   </div>
	  </div>
   </div>
</div>
</div>
</div>
<!-- jQuery (Bootstrap �� JavaScript �����Ҫ���� jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- ���������ѱ���Ĳ�� -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>
