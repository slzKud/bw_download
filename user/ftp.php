<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-nomenu.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
session_start();
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
		$lowftp=getthesettings('lowftpper');
		$optftp=getthesettings('optftp');
		$ftpadress=getthesettings('ftpserveradress');
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
 <?php 
 if($optftp==1){
	 if($lowftp <= $_SESSION['permission']){
    $sqlf=loaddb("select passmd5 from bw_usertable where username='$username'");
	//echo "select passmd5 from bw_usertable where username=$username";
	$rox=mysqli_fetch_array($sqlf);
	$sqly=loaddb("select password from bw_ftp where userid='$username'");
	$roy=mysqli_fetch_array($sqly);
	//echo $rox['passmd5'];
	//echo $roy['password'];
	if($rox['passmd5']!= $roy['password']){
 echo "
		   <h2>FTP信息</h2> 
	  <hr>
	   <div class=container >
	   <h3>BetaWorld FTP现在可用！</h3>
	   <p class=lead>
	   服务器地址：$ftpadress<br>
	   用户名：$username<br>
       密码：密码已被用户手动更改<br>
	  </p>
       
</div>";
	}else{
 echo "
		   <h2>FTP信息</h2> 
	  <hr>
	   <div class=container >
	   <h3>BetaWorld FTP现在可用！</h3>
	   <p class=lead>
	   服务器地址：$ftpadress<br>
	   用户名：$username<br>
       密码：跟资源区密码相同<br>
	  </p>
       
</div>";
	}
       
	 }else{
		echo '
		   <h2>FTP信息</h2> 
	  <hr>
	   <div class="container" >
	   <h3>BetaWorld FTP现在可用！</h3>
	   <p class="lead">
	   对不起，你暂时无法使用FTP服务。<br>
	  </p>
	  </div>
       '; 
	 }
 }else{
	 echo '
	   <div class="container" >
	   <h3>BetaWorld FTP现在不可用！</h3>
	   </div>
       '; 
	 }
 ?>
	<a href="info.php"><button type="button" class="btn btn-primary"><返回个人信息</button></a>
<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#myModal">更改FTP密码</button>
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
                <h4 class="modal-title" id="myModalLabel">更改FTP密码</h4>
            </div>
            <div class="modal-body">
			请填写你的新密码后提交。<br>
			<div class="form-group">
    <label for="name">新密码</label>
    <input type="password" class="form-control" placeholder="请输入FTP的新密码" name="zytitle" id='newpass' value="" />
	</div> 
	<div class="form-group">
    <label for="name">确认新密码</label>
    <input type="password" class="form-control" placeholder="请再输入一次你的FTP新密码" name="zytitle" id='confirmpass' value="" />
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
		  $.post('../user/todo.php', { type: "changeftppass",pass:pass }, function (text, status) {
			  alert(text);
			  window.location.reload();		
		  });
		 
 }
 </script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';?>
</html>