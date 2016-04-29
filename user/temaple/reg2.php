  <!--
 注册第二步模板
 -->
 <div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>注册 - Step 3</h2> 
	  <hr>
	  <h3>邮箱验证已经通过，请补充下面的信息完成注册。</h3>
	  <br><br>
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>
	  <form class="form-horizontal" action='reg.php?step=4' method="post" id="PassForm">
   <div class="form-group">
      <label for="username" class="col-sm-2 control-label">用户名</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="user" name="username"
            placeholder="请输入用户名">
      </div>
   </div>
   <div class="form-group">
      <label for="password"  class="col-sm-2 control-label ">密码</label>
      <div class="col-sm-10">
         <input type="password" class="form-control" id="password" name="userpass"
            placeholder="请输入密码">
      </div>
   </div>
    <div class="form-group">
      <label for="password"  class="col-sm-2 control-label ">确认密码</label>
      <div class="col-sm-10">
         <input type="password" class="form-control" id="password" name="userpassagain"
            placeholder="请再次输入密码">
      </div>
   </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button name="submitbutton" class="btn btn-primary" onclick="javascript:ok_user();">注册</button>
      </div>
   </div>
</form><br><br>
<br>
</div>
