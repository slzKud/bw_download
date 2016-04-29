  <!--
第三步模板
 -->
 <div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>找回用户名</h2> 
	  <hr>
	  <h3>你的账户名为：<?php echo $findusername;?>，请妥善保管。</h3>
	  <br><br>
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>
	  
         <a href="login.php" ><button name="submitbutton" class="btn btn-success">前往登入界面</button></a>
		 </div>
