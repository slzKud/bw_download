<?php include './interface/header-install.php';
if(file_exists("install.lock")){
	echo '<div class="container" ><br><h2>安装</h2><hr>你已经安装过了，如果需要重新安装，请删除install.lock文件后重试。 ';
	exit();
}
 ?>
<div class="container" >
 <br>
 <!--
 标题
 -->
	  <h2>安装</h2> 
	  <hr>
	  <br>
<br>
<br>
<form class="form-horizontal" role="form" action="installprog.php" method ="post" >
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">Mysql数据库地址</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="mysql" name="mysql" placeholder="请输入Mysql数据库地址">
    </div>
  </div>
   <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">Mysql数据库端口</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="port" name="port" placeholder="请输入Mysql数据库端口">
    </div>
  </div>
   <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">Mysql数据库用户名</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="muser" name="muser" placeholder="请输入Mysql数据库用户名">
    </div>
  </div>
   <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">Mysql数据库密码</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="mpass" name="mpass" placeholder="请输入Mysql数据库地址">
    </div>
  </div>
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">数据库名</label>
    <div class="col-sm-10">
      <input  class="form-control" id="mname" name="mname" placeholder="请输入Mysql数据库地址">
    </div>
  </div>
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">管理员账户</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="username" name="username" placeholder="请输入管理员账户">
    </div>
  </div>
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">管理员密码</label>
    <div class="col-sm-10">
      <input type="password" type="password" class="form-control " id="userpass" name="userpass" placeholder="请输入管理员密码">
    </div>
  </div>
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">管理员邮箱</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="useremail" name="useremail" placeholder="将同时作为反馈邮箱">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">开始安装</button>
    </div>
  </div>
</form>
</div> 
<br>
</div>  