 <?php
//预备 收集信息用于调查
empty($_GET['base64'])&&$_GET['base64']=0;
$errormsg=base64_decode($_GET['base64']);
include 'interface/header-nomenu.php';
?>
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
<div class="container" >

 <br>
<h1>:(</h1><br>
非常抱歉，Betaworld资源区出了一些小问题。<br>
请刷新，如果还是不行。联系管理员吧。
<br>
Log:<?php echo $errormsg; ?>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
</html>