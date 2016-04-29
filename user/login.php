<?php 
//相关模块
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
//退出代码
empty($_GET['type']) && $_GET['type'] = 'login';

if ($_GET["type"]=="logout") {
  setcookie("bwuser", "", time()-3600,"/");
  if(empty($_GET["url"])) {
		echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		exit;
		}else{
		echo "<meta http-equiv='refresh' content='1;url=".$_GET["url"]."'> ";
		exit;
		}
		}
session_start();
session_destroy();
//定义登陆量
empty($_POST['autologin']) && $_POST['autologin'] = '2';
$username=$pass=$yzm=$LErr="";
$adday=1;
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
   if (empty($_POST["usertext"])) {
     $LErr .="用户名是必填的<br>";
   } else {
     $username = test_input($_POST["usertext"]);
   }
   
   if (empty($_POST["password"])) {
     $LErr .= "密码是必填的<br>";
   } else {
     $pass = test_input($_POST["password"]);
   }
   
   if (empty($_POST["yzm"])) {
     $LErr .= "验证码是必填的<br>";
   } else {
     $yzm = strtolower(test_input($_POST["yzm"]));
   }
	   if($_POST["autologin"]=="1"){
     $adday = 30;
	 //echo "<script>alert('成功！');</script>";
	 }
 
   $rs=loaddb("SELECT id FROM bw_usertable where username='".$username."' and passmd5='".md5($pass)."'");
   if($LErr==""){
	if($yzm==$_SESSION['authnum_session']){
		if(mysqli_num_rows($rs) >0){
		//成功后跳转代码
	    //echo "<script>alert('成功！');</script>";
		//测试cookies代码
		//setcookie("bwuser", "#########Test########", time()+3600,"/");
        makecookies($username,md5($pass),$adday);
		if (empty($_GET["url"])) {
		echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		exit;
		}else{
		echo "<meta http-equiv='refresh' content='1;url=".$_GET["url"]."'> ";
		exit;
		}

		
    }else{
	 $LErr .="用户名或密码错误<br>";
 }
 }else{
	  $LErr .="验证码错误<br>";
	}
}
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-nomenu.php';
?>
<body>
<script type="text/javascript">
function ok_user(){
	 var form = document.getElementById("PassForm");
	 form.submit();
}
</script>
 <div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>登入</h2> 
	  <hr>
	  
<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>

	  <!--
	  登入区
	  -->
	  <?php
	  
	  //传递跳转url(如果有)
	  if (empty($_GET["url"])) {
		$tzzf="./login.php";
		}else{
		$tzzf="./login.php?url=".$_GET["url"];
		}
	  ?>
	  <form class="form-horizontal" action=<?php echo($tzzf);?> method="post" id="PassForm">
   <div class="form-group">
      <label for="username" class="col-sm-2 control-label">用户名</label>
      <div class="col-sm-8">
         <input type="text" class="form-control" id="usertext" name="usertext"  value='<?php echo($username);?>'
            placeholder="请输入用户名">
      </div>
   </div>
   <div class="form-group">
      <label for="password"  class="col-sm-2 control-label ">密码</label>
      <div class="col-sm-8">
         <input type="password" class="form-control" id="password" name="password" value='<?php echo($pass);?>'
            placeholder="请输入密码">
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
         <div class="checkbox">
            <label>
               <input type="checkbox" name="autologin" value="1"> 在30天内自动登录
            </label>
         </div>
      </div>
   </div>
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button name="submitbutton" class="btn btn-primary" onclick="javascript:ok_user();">登录</button>
      </div>
   </div>
</form>
<blockquote>
<p>
如果你无法登入，点<a href="cantlogin.php" >这里</a>。</p>
<p>
没有账户？<a href="reg.php" >注册</a>一个吧。</p>
</blockquote><br>


</div>
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';?>
</html>