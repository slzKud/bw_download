<html>
<?php 
//引入网页内容
include dirname(dirname(__FILE__)).'/interface/header-nomenu.php';
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once dirname(dirname(__FILE__)).'/module/sendmail.api.php';
session_start();
//session_destroy();
empty($_GET['step']) && $_GET['step'] = '1';
//empty($_SESSION['nowstep']) && $_SESSION['nowstep'] = '1';
$nowstep=1;
$LErr="";
//$nowstep=$_SESSION['nowstep'];
$nowstep=$_GET['step'];
switch ($nowstep)
{
case 2:
$email=$yzm=$LErr="";
 if (empty($_POST["email"])) {
     $LErr .= "邮箱是必须的<br>";
   } else {
     $email = test_input($_POST["email"]);
	 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
  $LErr = "无效的 email 格式."; 
}
   }  
   if (empty($_POST["yzm"])) {
     $LErr .= "验证码是必填的<br>";
   } else {
     $yzm = strtolower(test_input($_POST["yzm"]));
   }
    if($LErr==""){
	if($yzm==$_SESSION['authnum_session']){
		//检测用户是否存在
    $rsemail=loaddb("SELECT id FROM bw_usertable where email='".$email."'");
	if(mysqli_num_rows($rsemail) <= 0){
		$LErr .= "邮箱未被注册<br>";
	}
	if($LErr==""){
		//用session保存当前步骤，避免越卡
		$_SESSION['nowstep'] = '3';
		$nowtimestamp=time();
		$yzlink='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?step=3&email=".$email."&timestamp=".$nowtimestamp."&yzcode=".md5("step=3email=".$email."timestamp=".$nowtimestamp."BETAWORD2016F!!!");
		$toemail=$email;
        $nowaction="找回用户名";
        $tolink=$yzlink;
        $title='BetaWorld 资源区 - 邮件验证';
		//include dirname(dirname(__FILE__)).'/module/sendmail.php';
		SendMailToUser($toemail,$title,$nowaction,$tolink);
	}
	}else{
		$LErr .= "验证码不正确<br>";
	}
	}
  break;
case 3:
//邮箱验证
$regemail=$regtimestamp=$yzcode="";
if (empty($_GET["email"])) {
     $LErr .= "邮箱是必须的<br>";
	 $nowstep=100;
   } else {
     $regemail = test_input($_GET["email"]);
   }
   if (empty($_GET["timestamp"])) {
     $LErr .= "时间戳是必须的<br>";
	 $nowstep=100;
   } else {
     $regtimestamp= test_input($_GET["timestamp"]);
   }
   if (empty($_GET["yzcode"])) {
     $LErr .= "验证码是必须的<br>";
	 $nowstep=100;
   } else {
     $yzcode= test_input($_GET["yzcode"]);
   }
 if($LErr==""){
   $nowtime=time();
   if ($nowtime-$regtimestamp <= 1800){
	   $newcode=md5("step=3email=".$regemail."timestamp=".$regtimestamp."BETAWORD2016F!!!");
	   if($newcode==$yzcode){
   $con=loaddb("select username from bw_usertable where email='".$regemail."'");
   $row=mysqli_fetch_array($con);
   $findusername=$row['username'];
   
	   }else{
		   $LErr .= "验证码无效，参数可能遭到了篡改<br>";
		    $nowstep=100;
	   }
   }else{
	   $LErr .= "此链接已过期，请重新申请。<br>";
	   $nowstep=100;
   }
   }

  break;
  case 4:
  
    break;
}
if($LErr!=""){
	//错误处理
	if($nowstep !=100){
		$nowstep=$nowstep-1; //强制返回上一步
	}else{
			$nowstep=4; //报错
		}
	
	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
<script type="text/javascript">
function ok_user(){
	 var form = document.getElementById("PassForm");
	 form.submit();
}
</script>
<?php
 switch ($nowstep)
{
case 1:
empty($email) && $email = '';
 include './temaple/findusername1.php';
  break;
  case 2:
empty($email) && $email = '';
 include './temaple/findusername2.php';
  break;
case 3:
empty($findusername) && $findusername = '';
  include './temaple/findusername3.php';
  break;
  case 4:
   include './temaple/error.php';
  break;
default:
  $nowstep=1;
  include './temaple/findusername1.php';
}
 ?>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>
</html>