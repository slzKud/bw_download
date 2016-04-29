<html>
<?php 
$nowpageid=1;
include 'interface/header.php';
?>
<body>
 <div class="jumbotron masthead" style="background-image: url(back.jpg); no-repeat: repeat; text-align: center ;background-size:cover;">
   <div class="container">
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
      <p>开始你的Beta之旅！</p>
	  

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
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>