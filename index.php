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
include 'interface/header.php';
?>
<body>

 <div class="jumbotron masthead" style="background-image: url(module/img.php?folder=image); no-repeat: repeat; text-align: center ;background-size:cover;); no-repeat: repeat; text-align: center ;background-size:cover; color=#fffff ;">
   <div class="container" id="w">
  		<br />
   <br />
			<br />
			<br />
			<br />
			<br />
				<br />
			<br />
			<br />
			<br />
      <h1>欢迎来到BetaWorld资源区！</h1>
      <p>开始你的Beta之旅！<a href="about.php#us">了解更多</a></p>
	  

      <p>
	  <?php
	  //自动判断cookie
	  if (isset($_COOKIE["bwuser"])){
      echo "<a href='../downlist.php' class='btn btn-primary btn-lg' role='button'>
         前往资源区</a>";
       }else{
		    echo "<a href='./user/login.php' class='btn btn-primary btn-lg' role='button'>
         登入</a>";} 
         
       ?>
      </p>
	  <br />
			<br />
			<br />
			<br />
			<br />
				<br />
			<br />
			<br />
			<br />
			<br />
   </div>
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>