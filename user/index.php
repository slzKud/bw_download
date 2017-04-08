<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-user.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/ip.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/bwftp.php';
//session_start();
//自动判断cookie
function makemb($username){
	$r1=0;
	$r=getftpinfo($username,"StatsDownloaded");
$r1=getftpinfo($username,"DefaultLimit");
if($r<(1024*1024*1024)){
$r2= round($r/(1024*1024),2);
$r3= round($r1/(1024*1024*1024),2);
return $r2."MB/".$r3."GB";
exit;
}
if($r<(1024*1024)){
 $r2= round($r/(1024),2);
$r3= round($r1/(1024*1024*1024),2);
return $r2."KB/".$r3."GB" ;
exit;  
}
$r2= round($r/(1024*1024*1024),2);
$r3= round($r1/(1024*1024*1024),2);
return $r2."GB/".$r3."GB";
}
function progvalue($username){
	$r1=0;
$r=getftpinfo($username,"StatsDownloaded");
$r1=getftpinfo($username,"DefaultLimit");
if($r1==0){return 0;}
return ($r/$r1)*100;
}
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
        $ftpadress=getthesettings('ftpserveradress');
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

 <div class="col-md-8 col-center-block">
	<div class="row">
    	<div class="page-header">
            <h1>欢迎, <?php echo $username; ?>
                <small>这是你的个人信息</small>
            </h1>
        </div>
    </div>
     <div class="container" >
     
    <div class="row">
    	<div class="col-md-6">
        	<div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">用户信息</h3>
                </div>
                <div class="panel-body">
                    <h4>
                    	用户名：<?php echo $username; ?><br><br>
                        用户权限：<?php echo $userqx; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="admituser.php"><button type="button" class="btn btn-success btn-xs">更改权限</button></a><br><br>
                        注册时间：<?php echo $regdate; ?><br><br>
                        登陆时间：<?php echo $lastlogindate; ?><br><br>
                        上次登录的IP地址和地区：<?php echo $lastip."  ".$lastloc; ?><br><br>
                    </h4>  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">用户密码修改</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">旧密码</label>
                        <div class="col-sm-10">
                          	<input type="password" class="form-control" id="oldPassword" placeholder="请输入旧密码"><br>
                        </div>
                        <label for="inputPassword" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                          	<input type="password" class="form-control" id="newPassword" placeholder="请输入新密码"><br>
                        </div>
                        <label for="inputPassword" class="col-sm-2 control-label">密码确认</label>
                        <div class="col-sm-10">
                          	<input type="password" class="form-control" id="confirmpass" placeholder="请再输入一次你的新密码"><br>
                        </div>
                    </div>
                    <h4><span class="glyphicon glyphicon-ok" style="color: rgb(74, 134, 232);"> 邮箱已验证</span></h4>
                    <div class="col-md-10"></div><div class="col-md-2"><button type="button" class="btn btn-primary btn-sm"  onclick="ModUserPass();">提交修改</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">FTP信息</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 border-right" style=" border: solid; border-width:0px 2px 0px 0px; border-color: #006699">
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
		 <h2> Public/公共 </h2>
                            <h4>
                                当前状态：可用<br><br>
                                用户名：$username<br><br>
                                密码：已被用户手动更改  <button type=‘button’ class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal'>更改密码</button><br><br>
                                FTP地址：$ftpadress<br><br>
								FTP端口：48893<br><br>
								FTP加密方法：隐式TLS FTP加密。<br><br>
                            
                            ";
	}else{
 echo "
<h2> Public </h2>
                            <h4>
                                当前状态：可用<br><br>
                                用户名：$username<br><br>
                                密码：与资源区相同 <button type=‘button’ class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal'>更改密码</button><br><br>
                                FTP地址：$ftpadress<br><br>
								FTP端口：48893<br><br>
								FTP加密方法：隐式TLS FTP加密。<br><br>
                            ";
	}
     //echo "<a href=ftppay.php><button type='button' class='btn btn-primary'>购买FTP流量</button></a>  ";
	 }else{
		echo '
        <h2> Public/公共 </h2>
                            <h4>
                                当前状态：可用<br><br>
                                对不起，你现在无法使用FTP服务。<br><br>
                           
       '; 
	 }
 }else{
	 echo '
	    <h2> Public/公共 </h2>
                            <h4>
                                当前状态：不可用<br><br>
                                对不起，FTP服务现在不可用。<br><br>
                            
       '; 
	 }
	 if(getthesettings('optftp')==1){
if(getthesettings('ftpmode')==1){
      echo "流量：暂不可用 <br><br>";
	 }elseif(getthesettings('ftpmode')==2){
		 $m=makemb($username);
		 $p=progvalue($username);
	echo scanserver()."<br><br>";
    echo "当前使用流量：$m  <button type=‘button’ class='btn btn-success btn-xs' onclick='a();'>购买流量</button><br><br>";
	 }else{
		 $p=0;
	 }
	 }
	 empty($p)&&$p=0;
 ?>

</h4>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="<?php echo $p;?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width: <?php echo $p;?>%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<h2> B-Side </h2>
                            <h4>
                                当前状态：不可用 &nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="b();">为什么？</a><br><br>
                                流量：0G/0G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success btn-xs" disabled="disabled">流量管理</button><br><br>
                            </h4>
                             当前使用流量：
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                     style="width: 63.2%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       	</div>
    </div>
</div>
</div>
</div>
<br>

<script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<script>
 function ModUserPass(){
	  var oldpass=document.getElementById("oldPassword").value;
      var pass=document.getElementById("newPassword").value;
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
		 if(pass1.length<6){
			 alert('密码长度小于6！');
			 return 0;
		 }
		  $.post('../user/todo.php', { type: "changeuserpass",oldpass:oldpass,newpass:pass }, function (text, status) {
			  alert(text);
			  console.log(text);
			  window.location.href="login.php?type=logout";	
		  });
		 
 }
  function a(){alert('功能尚未开发完成！');}
   function b(){alert('因为B-side还没启用呢，哼！');}
 </script>
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
    <input type="password" class="form-control" placeholder="请输入FTP的新密码" name="zytitle" id='ftpnewpass' value="" />
	</div> 
	<div class="form-group">
    <label for="name">确认新密码</label>
    <input type="password" class="form-control" placeholder="请再输入一次你的FTP新密码" name="zytitle" id='ftpconfirmpass' value="" />
	</div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ModFTPthing();">更改</button>
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
 function ModFTPthing(){
      var pass=document.getElementById("ftpnewpass").value;
		 var pass1=document.getElementById("ftpconfirmpass").value; 
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
		 if(pass1.length<6){
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