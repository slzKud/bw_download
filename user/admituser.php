<html>
<style>
#w
{
font-family : 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
font-size : 1em;
color : #C0C0C0;
}
</style>
<body>
<br>
<div class="container">
   <h2>用户组更改申请</h2> 
 <hr>
<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
 if (isset($_COOKIE["bwuser"])){
if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
	       echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		   exit;
	   }
 }
$nowpageid=1;
include '../interface/header-nomenu.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
 if(getthesettings("opensh")!= "1"){
	   
	   $LErr="对不起，此功能已被管理员禁用。";
	   echo '
<div class="alert alert-danger">'.$LErr.'</div>
</div>';
include '../interface/footer.php';
exit;
   }
?>

  <div class="form-group">
    <label for="name">用户名</label>
    <p class="form-control-static" id="payid">XXXXXX</p> 
	</div>
 <div class="form-group">
    <label for="name">用户现在权限</label>
    <p class="form-control-static" id="payid">XXXXXX</p> 
	</div>
	
	<div class="form-group">
	 <label for="name">想更改的用户组</label>
      <select class="form-control" name="fktype">
         <option> 高级用户</option>
         <option>VIP</option>
      </select>

</div>
<button type="button" class="btn btn-primary btn-lg btn-block" onclick="Sumbit();">申请</button>
 </div>
	  
	 
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include '../interface/footer.php';?>
</html>