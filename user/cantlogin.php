<html>
<?php 
//引入网页内容
include dirname(dirname(__FILE__)).'/interface/header-nomenu.php';
?>
<body>
 <div class="container" >
 <br>
 <!--
 标题
 -->
	  <h2>无法登陆？<small>喂，你忘了啥啊...</small></h2> 
	  <hr>
	   <div class="container" >
	  <h3>请选择无法登陆的原因</h3>
	  <br>
       <label for="username" class="col-sm-2 control-label">用户名找不到了：</label><div class="col-sm-10"><a href="findusername.php" ><button type="button" class="btn btn-primary">找回用户名</button></a></div><br><br>
	   <label for="username" class="col-sm-2 control-label">密码忘了：</label><div class="col-sm-10"><a href="resetpass.php" ><button type="button" class="btn btn-primary">重置密码</button></a></div><br><br>
	   <label for="username" class="col-sm-2 control-label">还是其他原因：</label><div class="col-sm-10"><a href="../feedback.php" ><button type="button" class="btn btn-primary">反馈</button></a></div><br><br>

</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>
</html>