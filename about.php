<html>
<style>
#w
{
font-family : 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
font-size : 1em;
color : #C0C0C0;
}
</style>

<?php 
$nowpageid=1;
include dirname(__FILE__).'/interface/header-nomenu.php';
?>
<link href="./css/top.css" rel="stylesheet">
<body>
<div id="updown"><span class="up"></span></div>
<br>
<div class="container">
<?php
if(file_exists("about.md")){
 include 'module/Parsedown.php';
	  $Parsedown = new Parsedown();
echo $Parsedown->text(file_get_contents('about.md'));
}else{
echo "About.md 文件不存在，请手动添加。";
}
	 
?> 
	  </div>
	 
	 
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
	  <script src="./js/top.js" type="text/javascript"></script>
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>