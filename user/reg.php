<?php
$loginflag=1;
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once dirname(dirname(__FILE__)).'/module/sendmail.api.php';
include_once dirname(dirname(__FILE__)).'/module/ip.php';
session_start();
//session_destroy();
empty($_GET['step']) && $_GET['step'] = '1';
//empty($_SESSION['nowstep']) && $_SESSION['nowstep'] = '1';
$nowstep=1;
$LErr="";
//$nowstep=$_SESSION['nowstep'];
$nowstep=$_GET['step'];
if(getthesettings("closereg")==="1"){
	$LErr="注册已经关闭。过几天再来吧。";
	$nowstep=100;
}
if(getthesettings("blocknotinchina")==="1"){
  $ip_user=get_IP();
	$loc= getIPLocCode($ip_user);
  if($loc!='CN' && $loc!='LOCAL'){
    $LErr="注册已经关闭。过几天再来吧。";
    $nowstep=100;
  }else{
    if(Get_UserLang()!='zh'){
      $LErr="注册已经关闭。过几天再来吧。";
      $nowstep=100;
    }
  }

}
	//表单处理
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
	if(mysqli_num_rows($rsemail) >0){
		$LErr .= "邮箱已被注册<br>";
	}
	if($LErr==""){
		//用session保存当前步骤，避免越卡
		$_SESSION['nowstep'] = '3';
		$nowtimestamp=time();
		$yzlink='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?step=3&email=".$email."&timestamp=".$nowtimestamp."&yzcode=".md5("step=3email=".$email."timestamp=".$nowtimestamp."BETAWORD2016!!!");
		$toemail=$email;
        $nowaction="注册邮件验证";
        $tolink=$yzlink;
        $title='BetaWorld 资源区 - 邮件验证';
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
	   $newcode=md5("step=3email=".$regemail."timestamp=".$regtimestamp."BETAWORD2016!!!");
	   if($newcode==$yzcode){
		   $_SESSION['regemail'] = $regemail;
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
  //注册
  if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$regusername=$regpassword=$againpassword=$email="";
	$email=$_SESSION['regemail'];
  if (empty($_POST["username"])) {
     $LErr .= "用户名是必须的<br>";
   } else {
     $regusername = test_input($_POST["username"]);
	 //echo $regusername;
   }
   if (empty($_POST["userpass"])) {
     $LErr .= "密码是必须的<br>";
   } else {
     $regpassword= test_input($_POST["userpass"]);
   }
   if (empty($_POST["userpassagain"])) {
     $LErr .= "密码是必须的<br>";
   } else {
    $againpassword= test_input($_POST["userpassagain"]);
	if($againpassword!=$regpassword){
		$LErr .= "密码和确认密码不等<br>";
	}
   }
   if(strlen($regpassword)<6){
		$LErr .= "密码最小长度小于6位，不允许注册<br>";
	  }
   if($LErr==""){
   //检测用户是否存在
    if(!checkusername($regusername)){
      $LErr .= "用户名不符合规范<br>";
    }
    $rsuser=loaddb("SELECT id FROM bw_usertable where username='".$regusername."'");
	if(mysqli_num_rows($rsuser) >0){
		$LErr .= "用户已存在<br>";
  }
  $rsuser=loaddb("SELECT id FROM bw_usertable where email='".$email."'");
	if(mysqli_num_rows($rsuser) >0){
		$LErr .= "注册所用邮箱已存在<br>";
	}
	if($LErr==""){
		//开始注册
		//拼接SQL
		$regdate=date('Y-m-d H:i:s');
		$sql="INSERT INTO bw_usertable (username, passmd5,email,permission,regdate) VALUES ('".$regusername ."', '".md5($regpassword)."','".$email."','1','".$regdate."')";
		//$con=connectdb();
		//echo $sql;
		//mysqli_query($con,$sql);
		//mysqli_close($con);
    loaddb($sql);
		//FTP部分
			$optftp=getthesettings('optftp');
		$lowftp=getthesettings('lowftpper');
		if($optftp==1){
		if($lowftp=1){
    
     if(getthesettings("ftpmode")==1){
			$sql1="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser1') ."', '".$regusername."','".md5($regpassword)."')";
			loaddb($sql1);
     }else{
       $sql1="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser1') ."', '".$regusername."','".md5($regpassword)."')";
			loaddb($sql1);
      include_once  dirname(dirname(__FILE__)).'/module/bwftp.php';
      regftpuser($regusername,$regpassword,getthesettings('ftpuser1'));
     }
		}
		}
	}
     }
    break;
}
}

if($LErr!=""){
	//错误处理
	if($nowstep !=100){
		$nowstep=$nowstep-1; //强制返回上一步
	}else{
			$nowstep=5; //报错
		}
	
	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function checkusername($username){
  if (strlen($username)<3 || strlen($username)>8){return(false);}
  if(strpos($username,' ')!=FALSE){return(false);}
  if (preg_match('/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\（|\）|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\s+/',$username)){return(false);}
  return(true);
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
 <?php
 switch ($nowstep)
{
case 1:
empty($email) && $email = '';
 include './temaple/reg1.php';
  break;
  case 2:
empty($email) && $email = '';
 include './temaple/regwait.php';
  break;
case 3:
  include './temaple/reg2.php';
  break;
case 4:
   include './temaple/reg3.php';
  break;
  case 5:
   include './temaple/error.php';
  break;
default:
  $nowstep=1;
  include './temaple/reg1.php';
}
 ?>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>
</html>