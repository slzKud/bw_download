  <!--
 注册第一步模板
 -->
 <div class="container" >
 <br>
 <!--
 标题
 -->
	  <h2>注册 - Step 1</h2> 
	  <hr>
	  <h3>请输入你的邮箱以继续注册。</h3>
	  <br><br>
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>
	  <form class="form-horizontal" action='reg.php?step=2' method="post" id="PassForm" >
   <div class="form-group">
      <label for="username" class="col-sm-2 control-label">电子邮箱</label>
      <div class="col-sm-8">
         <input type="text" class="form-control" id="usertext" name="email" value='<?php echo $email;?>' placeholder="请输入注册的邮箱">
      </div>
   </div>
  
   <div class="form-group">
      <label for="password" class="col-sm-2 control-label">验证码</label>
      <div class="col-sm-6">
         <input type="text" class="form-control" id="yzm" name="yzm"
            placeholder="请输入验证码">
	 
	  </div>
	 <div class="col-sm-4">
         <img  title="点击刷新" height="35px" src="../module/captcha.php" align="absbottom" onclick="this.src='../module/captcha.php?'+Math.random();"></img>
      </div>

   </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button name="submitbutton" class="btn btn-primary" onclick="javascript:ok_user();">下一步</button>
      </div>
   </div>
</form><br><br>
<blockquote><p>
有了账户？<a href="login.php" >登入</a>吧。</p></blockquote><br>
</div>
