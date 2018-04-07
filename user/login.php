<?php 
//相关模块
include dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include dirname(dirname(__FILE__)).'/module/cookiesmaker.php';
session_start();
session_destroy();
//退出代码
empty($_GET['type']) && $_GET['type'] = 'login';
empty($orgusername) && $orgusername = '';

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
//验证登录
  if (isset($_COOKIE["bwuser"])){
     if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
       $LErr="你已经登录用户".veifycookies($_COOKIE["bwuser"]).".5秒后返回首页。";
       include dirname(dirname(__FILE__)).'/interface/header-nomenu.php';
       echo " <div class='container'' ><br><h2>Opps</h2> 
	  <hr><div class='alert alert-danger'>".$LErr."</div></div>";
    echo "<meta http-equiv='refresh' content='5;url=../index.php'> ";
      include dirname(dirname(__FILE__)).'/interface/footer.php';
      exit;
     }
  }
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
 //判断是邮箱还是用户名登录,如果是邮箱就转换成用户名
 $orgusername=$username;
$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
  if ( preg_match( $pattern, $username ) ){
$rs1=loaddb("SELECT username FROM bw_usertable where email='".$username."'");
	if(mysqli_num_rows($rs1) >0){
    $row1=mysqli_fetch_array($rs1);
		$username=$row1['username'];
  }
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
		$ip=getIP();
	    $logindate=date('Y-m-d H:i:s');
		$sqll="update bw_usertable set lastip='$ip',lastlogindate='$logindate' where username='$username'";
		loaddb($sqll);
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
function getIP(){
global $ip;
if (getenv("HTTP_CLIENT_IP"))
$ip = getenv("HTTP_CLIENT_IP");
else if(getenv("HTTP_X_FORWARDED_FOR"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if(getenv("REMOTE_ADDR"))
$ip = getenv("REMOTE_ADDR");
else $ip = "Unknown";
return $ip;
}
?>
<html>
<?php 
//引入网页内容
include dirname(dirname(__FILE__)).'/interface/header-nomenu.php';
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
      <label for="username" class="col-sm-2 control-label">用户名/邮箱</label>
      <div class="col-sm-8">
         <input type="text" class="form-control" id="usertext" name="usertext"  value='<?php echo($orgusername);?>'
            placeholder="请输入用户名或者注册邮箱">
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
<?php 
if(getthesettings("closereg")!="1"){
	echo '<p>
没有账户？<a href="reg.php" >注册</a>一个吧。</p>';
}
?>
</blockquote><br>


</div>
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>
</html>