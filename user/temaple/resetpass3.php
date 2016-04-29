  <!--
 注册第二步模板
 -->
 <div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>重置密码 - Step 3</h2> 
	  <hr>
	  <h3>邮箱验证已经通过，可以更改密码了。</h3>
	  <br><br>
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>
	  <form class="form-horizontal" action='resetpass.php?step=4' method="post" id="PassForm">
   <div class="form-group">
      <label for="password"  class="col-sm-2 control-label ">新密码</label>
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
         <button name="submitbutton" class="btn btn-primary" onclick="javascript:ok_user();">更改密码</button>
      </div>
   </div>
</form><br><br>
<br>
</div>
