<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-user.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/ip.php';
//session_start();
//自动判断cookie
	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if ($_SESSION['permission']==0){
	  $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
	  $row=mysqli_fetch_array($con);
     $_SESSION['permission']=$row['permission'];
	 }
	  if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
	       echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		   exit;
	   }
		$username= veifycookies($_COOKIE["bwuser"]);
		$rs=loaddb("select lastip,lastlogindate,regdate from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
		$row1=mysqli_fetch_array($rs);
		$lastip=$row1['lastip'];
		$lastloc=getIPLoc($lastip);
		$lastlogindate=$row1['lastlogindate'];
		$regdate=$row1['regdate'];
		$lowftp=getthesettings('lowftpper');
		$optftp=getthesettings('optftp');
		$opsh=getthesettings('opensh');
		if($optftp==1){
			if($_SESSION['permission']>=$lowftp){
				$str1="有";
			}else{
				$str1="无";
			}
		}else{
				$str1="不适用";
			}
	  
		
		switch($_SESSION['permission']){
				case '1':
				$userqx="普通用户";
				  break;
				case '2':
				$userqx="高级用户";
				  break;
				case '3':
				$userqx="VIP";
				  break;
				case '4':
				$userqx="管理员";
				  break;
				 default:
				$userqx="未知";
				  break;
			}
	  }else{
		  echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
			exit; 
	  }
         
?>
<body>
 <div class="container" >
 <br>
 <!--
 标题
 -->
	  <h2>用户信息</h2> 
	  <hr>
	   <div class="container" >
	   <p class="lead">
	   <?php
	   echo "
	   用户名：$username<br>
	   组别：$userqx<br>
	   ";
	   if($optftp==1){echo "是否有FTP：$str1<br>";}
       echo "注册时间：$regdate<br>
	   上次登录时间：$lastlogindate <br>
	   上次登录IP及地区：$lastip $lastloc<br>";?></p>
     <!--  <a href="emailsend.php"><button type="button" class="btn btn-primary">电邮联系</button></a>  -->
		<?php if($optftp==1){echo '<a href="ftp.php"><button type="button" class="btn btn-primary">查看FTP账户信息</button></a>';} ?>
		<?php if($opsh==1){echo '<a href="admituser.php"><button type="button" class="btn btn-primary">用户组更改</button></a>';} ?>
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >账户密码修改</button>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">账户密码更改</h4>
            </div>
            <div class="modal-body"> 
			请填写你的新密码并验证原有的密码后提交。如果你的原密码已忘记，请用<a href="resetpass.php">重置密码功能</a>。<br> * 更改完成后系统自动返回登录界面，请重新登录。<br>
			<div class="form-group">
    <label for="name">原密码</label>
    <input type="password" class="form-control" placeholder="请输入账户的原有密码" name="zytitle" id='oldpass' value="" />
	</div>
			<div class="form-group">
    <label for="name">新密码</label>
    <input type="password" class="form-control" placeholder="请输入账户的新密码" name="zytitle" id='newpass' value="" />
	</div> 
	<div class="form-group">
    <label for="name">确认新密码</label>
    <input type="password" class="form-control" placeholder="请再输入一次账户的新密码" name="zytitle" id='confirmpass' value="" />
	</div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ModSomething();">更改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
	$("[data-toggle='modal']").click(function(){
 var _target = $(this).attr('data-target')
 t=setTimeout(function () {
 var _modal = $(_target).find(".modal-dialog")
 _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
 },200)
 })
 function ModSomething(){
	  var oldpass=document.getElementById("oldpass").value;
      var pass=document.getElementById("newpass").value;
		 var pass1=document.getElementById("confirmpass").value; 
		  if(pass==""){
			 alert('密码空！');
			 return 0;
		 }
		  if(pass1==""){
			 alert('确认密码空！');
			 return 0;
		 }
		 if(pass!=pass1){
			 alert('密码不一致！');
			 return 0;
		 }
		 if(pass1.length<=6){
			 alert('密码长度小于6！');
			 return 0;
		 }
		  $.post('../user/todo.php', { type: "changeuserpass",oldpass:oldpass,newpass:pass }, function (text, status) {
			  alert(text);
			  console.log(text);
			  window.location.href="login.php?type=logout";	
		  });
		 
 }
 </script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';?>
</html>