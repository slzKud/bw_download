  <!--
 完成模板
 -->
 <div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>重置密码 - Finish</h2> 
	  <hr>
	  <h3>恭喜,你的账户已经重置密码成功！</h3>
	  <br><br>
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>
	  
         <a href="login.php" ><button name="submitbutton" class="btn btn-success">前往登入界面</button></a>
		 </div>
